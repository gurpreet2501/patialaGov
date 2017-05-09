<?php
use App\Models;
use App\Libs\Stock;

function place_order($remarks, $ordered_products, &$status, $booking_id =0){
 
  $customer = obj('users')->read(array(
    'select'    =>   array('username','email','full_name','phone_number','address_line_1','state','city','zip_code','district.district_name','country','address_line_2','customer_type'),
    'where'     =>   array('id',user_id())
  ));

 
  $customer = $customer[0];
  $customer['district'] = $customer['district']['district_name'];

  $order = [
    'remarks'   => $remarks,
    'user_id'   => user_id(),
    'plant_id'  => plant(),
    'status'    => 'Pending',
    'booking_id'=> $booking_id,
    'date'      => date('Y-m-d H:i:s'),
    'customer'  => $customer,
    'items'     => array(),
    'payment_details'     => ['receipt'                     => ''],
    // 'shpiment_export'     => ['stock_ready_for_inspection'  => 0],
    // 'shipment_domestic'   => [],
  ];

  remove_zero_quantity_items($ordered_products);

  if(empty($ordered_products)){
    $status = false;
    return false;
  }

  $prod_ids = array_keys($ordered_products);

 
  $products = obj('products')->read([
    'select'  => ['id','product_name','price','weight','weight_unit','customer_category_price.^*','only_sell_cases'],
    'where'   => ['id','IN',$prod_ids]
  ]);


  foreach($products as $key =>  $product){
  
    
    $item_cases_qty = $product['only_sell_cases'];
    unset($product['only_sell_cases']);
    $item =  $product;
    unset($item['id']);
    $item['product_id'] = $product['id'];
    $item['qty'] = $ordered_products[$product['id']]['qty'];

    if($booking_id){
      $discounts_taxes =  obj('booking_items')->read([
                              'select'  =>  ['discounts.^*','taxes.^*'],
                              'where'   =>  [['product_id',$item['product_id']],
                                            'AND',
                                            ['booking_id',$booking_id]]
                            ]);

      $item['discounts']  = $discounts_taxes[0]['discounts'];
      $item['taxes']      = $discounts_taxes[0]['taxes'];
      format_order_booking_discounts($item['discounts']);
      format_order_booking_taxes($item['taxes']);
      reduce_booking_product_stock($product['id'],$booking_id, $item['qty']);
    }else{

      $options = get_current_user_price($item);
    
      $final_price = false;
      if($options)
        list($item['price'],$final_price) = $options;

      $item['discounts'] = [];
      $item['taxes'] = [];

     
      $item['discounts'] = applied_discounts($item['qty'], $product['id'], user_id());
      $item['taxes'] = applied_taxes($item['qty'], $product['id'],user_id());
      format_order_discounts($item['discounts']);
      format_order_taxes($item['taxes']);
     
    
      unset($item['customer_category_price']);
    } //else part 

    $order['items'][] = $item;
  }
 
  $p_order = new lako_order_print($order);
  $order['total'] = $p_order->total();
  
  try{
    
    $saved_order = obj('orders')->insert($order);
   
    $status = true;
    return $saved_order['orders'];
  }catch(Exception $e){
    $status = false;
    return null;
  }
}
function place_export_order($remarks, $ordered_products, $status=null){
  
  $customer = obj('users')->read(array(
    'select'    =>   array('username','email','full_name','phone_number','address_line_1','state','city','zip_code','district.district_name','country','address_line_2','customer_type'),
    'where'     =>   array('id',user_id())
  ));

  $customer = $customer[0];
  $customer['district'] = $customer['district']['district_name'];

  $order = [
    'remarks'   => $remarks,
    'user_id'   => user_id(),
    'type'    =>  'Export',
    'status'    => 'Pending',
    'date'      => date('Y-m-d H:i:s'),
    'customer'  => $customer,
    'items'     => array(),
    // 'shpiment_export'     => ['stock_ready_for_inspection'  => 0],
    // 'shipment_domestic'   => [],
  ];
  
  remove_zero_quantity_items($ordered_products);

  if(empty($ordered_products)){
    $status = false;
    return false;
  }

  $prod_ids = array_keys($ordered_products);
 
  $products = obj('products')->read([
    'select'  => ['id','product_name','price','weight','weight_unit','customer_category_price.^*','export_price'],
    'where'   => ['id','IN',$prod_ids]
  ]);

  foreach($products as $product){
    
    $item =  $product;
    unset($item['id']);
    $item['product_id'] = $product['id'];
    
    $item['qty'] = $ordered_products[$product['id']]['qty']; 
   
    $options = get_current_user_price($item);
      
    $final_price = false;
    if($options)
      list($item['export_price'],$final_price) = $options;

    $item['discounts'] = [];
    $item['taxes'] = [];

    if(!$final_price){
      $item['discounts'] = applied_discounts($item['qty'], $product['id'], user_id());
      $item['taxes'] = applied_taxes($item['qty'], $product['id'],user_id());
      format_order_discounts($item['discounts']);
      format_order_taxes($item['taxes']);
    }
    
    reduce_product_stock($product['id'], $item['qty']);
    unset($item['customer_category_price']);
   
    $order['items'][] = $item;
  }
  
  $p_order = new lako_order_print($order);
  $order['total'] = $p_order->total();

   try{
    $saved_order = obj('orders')->insert($order);
    $status = true;
    return $saved_order;
  }catch(Exception $e){
    $status = false;
    return null;
  }
}

function attach_plant_id_with_export_order($orders){
  
  foreach ($orders['data'] as $key => $value) {
    
      $plant_ids = get_plant_ids_related_to_products($value['id']);
      $orders['data'][$key]['plant_ids'] = $plant_ids;
  }
  
  return $orders; 
}

function get_plant_ids_related_to_products($order_id){

  $products =Models\OrderItems::where('order_id', $order_id)->with(['product' => function ($query) {
        $query->withTrashed();
    }])->get();
 
  $plant_ids = [];
  foreach ($products as $key => $value) {
    $plant_ids[] = $value->product->plant_id;
  }
 
 $plant_ids =  array_unique($plant_ids);
 
 return $plant_ids;
  
}

function get_current_user_price($product){
  foreach($product['customer_category_price'] as $customer_category_price)
    if($customer_category_price['customer_category_id'] == user_category()->id)
      return [(Float)$customer_category_price['price'], (Boolean)user_category()->no_price_mod];

  return false;
}

function remove_zero_quantity_items(&$order_items){
  foreach($order_items as $key => $order_item)
    if(!intval($order_item['qty']))
      unset($order_items[$key]);
}



function order_details($id){
  $order = lako::get('objects')->get('orders')->read(array(
    'select'  => array( '^*',
                        'items.^*',
                        'items.taxes.^*',
                        'items.discounts.^*' ,
                        'customer.^*',
                        'payment_details.^*',
                        'depots_orders.^*',
                        'shpiment_export.^*',
                        'shipment_domestic.^*',
                        'plant.full_name'),
    'where'   => array('id',$id),
  ));
  
  return empty($order)? null: $order[0];
}


function stage_name($name){
  return ucwords(str_replace('_',' ',$name));
}
function stage_value($val){
  if(($val == '0') || ($val == ''))
    return "<span class='mute'>Pending</span>";
  else if($val == '1')
    return "<span class='success'>Completed</span>";
  return '<span class="success">'.htmlentities($val).'</span>';
}


function make_order_id($id){
  return 'MFP'.($id+100);
}


function reduce_stock_shared_order($product_id,$by){
  

  $product = obj('products')->read([
    'select'  => ['unique_hash'],
    'where'   => ['id', $product_id]
  ]);
  
  $prod = Models\Products::select('id','stock','plant_id')->where('unique_hash', $product[0]['unique_hash'])->where('plant_id', user_id())->first();  
 
  if(!$prod){
     lib('flash')->set('global',array(
                            'type'  => 'danger',
                            'msg'   => "Unable to ship. Product is not available in your stock."
     ));

     redirect(current_url());
  }

  if(empty($prod->stock) || $prod->stock == 0)
    return;

  Models\Products::where('id',$prod->id)->update([
      'stock' => ($prod->stock - $by)
    ]);
}

function reduce_product_stock($product_id, $by){

  $stock = obj('products')->read([
    'select'  => ['stock'],
    'where'   => ['id', $product_id]
  ]);
 

  if(empty($stock))
    return false;

  $stock = $stock[0]['stock'];

  if($stock<0 || $stock == 0)
    return false;

  obj('products')->update(
    ['stock'  => $stock-intval($by)],
    ['id', $product_id]
  );

  return true;
}

function reduce_shared_order_product_stock($product_id, $by){
  
  $product = obj('products')->read([
    'select'  => ['unique_hash'],
    'where'   => ['id', $product_id]
  ]);
  
  $prod = Models\Products::select('id','stock','plant_id')->where('unique_hash', $product[0]['unique_hash'])->where('plant_id', user_id())->first();  
 
  if(!$prod){
     lib('flash')->set('global',array(
                            'type'  => 'danger',
                            'msg'   => "Unable to ship. Product is not available in your stock."
     ));

     redirect(current_url());
  }

  if(empty($prod->stock) || $prod->stock == 0)
    return;

  Models\Products::where('id',$prod->id)->update([ 
      'stock' => ($prod->stock - $by)
    ]);
}


function reduce_booking_stock($product_id,$book_id, $by){

  $stock = obj('booking_items')->read([
    'select'  => ['remaining_stock','id'],
    'where'   => [['product_id',$product_id],
                  'AND',
                  ['book_id',$book_id]]
  ]);
  if(empty($stock))
    return;
  $stock = $stock[0]['remaining_stock'];

  return obj('booking_items')->update(
    ['remaining_stock'  => $stock-intval($by)],
    [['product_id',$product_id],
      'AND',
      ['book_id',$book_id]]
  );
}

function format_order_discounts(&$discounts){
  return format_booking_discounts($discounts);
}

function format_order_taxes(&$taxes){
  return format_booking_taxes($taxes);
}

function format_order_booking_discounts(&$discounts){
  foreach($discounts as $key => $discount){
    unset($discounts[$key]['id']);
    unset($discounts[$key]['booking_item_id']);
  }
}

function format_order_booking_taxes(&$taxes){
  return format_order_booking_discounts($taxes);
}

function redirect_url_on_adding_shipping($order_id){

  $role = user_role();

  if($role == 'depot')
      return site_url().'/depot/order_details/'.$order_id;
  else if($role == 'plant_manager')  
      return site_url().'/admin/order_details/'.$order_id;
}

function if_order_received($order_id){
  $data = Models\Orders::select('order_received')->where('id', $order_id)->first();
  return $data->order_received;
}

function is_shared($order_id){
  return (Boolean)Models\SharedOrders::where('order_id', $order_id)->count();
}

function is_export_order($order_id){
  return (Boolean)Models\Orders::where('order_id', $order_id)->where('type', 'Export')->count();
}


function get_ordered_quantity($product_id, $order_id){
  $data =Models\OrderItems::select('qty')->where(['product_id' => $product_id, 'order_id' => $order_id])->first();
  return $data->qty;
}

function check_if_order_already_shared($order_id){
  $ci = &get_instance();
  return (boolean)Models\SharedOrders::where('order_id', $order_id)->count();
}

function can_share_orders(){
  $ci = &get_instance();
  $data = Models\PlantsConfiguration::select('value')->where('key','can_share_orders')->where('plant_id', user_id())->first();

  return $data['value'];

}

function can_forward_orders(){
  $ci = &get_instance();
  $data = Models\PlantsConfiguration::select('value')->where('key','can_forward_orders')->where('plant_id', user_id())->first();
  return $data['value'];

}

function can_remove_order_items(){
  $ci = &get_instance();
  $data = Models\PlantsConfiguration::select('value')->where('key','can_remove_order_items')->where('plant_id', user_id())->first();
  return $data['value'];
}

function can_add_order_items(){
  $ci = &get_instance();
  $data = Models\PlantsConfiguration::select('value')->where('key','can_add_order_items')->where('plant_id', user_id())->first();
  return $data['value'];
}

function can_update_order_items(){
  $ci = &get_instance();
  $data = Models\PlantsConfiguration::select('value')->where('key','can_update_order_items')->where('plant_id', user_id())->first();
  return $data['value'];
}


function update_order_status($order_id){

  $order = Models\Orders::find($order_id);

  $completed = 1;
  $partial_shipped = 0;
  
  foreach($order->items as $item){
    $shippedQty = !empty($item->shippedQuantity) ? $item->shippedQuantity->total_shipped : 0;
    
    if($shippedQty)
      $partial_shipped = 1;

    if($shippedQty < $item->qty){
      $completed = 0;
    }
          
  }

  if($completed)
    $status = 'Completed';
  else if($partial_shipped)
    $status = 'Partially Completed';
  else
    $status = 'Pending';
  
  Models\Orders::where('id',$order_id)->update([
      'status' => $status
    ]);  

}
