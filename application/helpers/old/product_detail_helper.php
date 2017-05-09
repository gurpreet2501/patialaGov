<?php
use App\Models as M;

function get_prod_detail($id){
  $data = lako::get('objects')->get('products')->read(array(
    'select'  =>  array('product_name', 'weight_unit', 'weight','price' ,'id','image','only_sell_cases','export_price'),
    'where'   =>  array('id', $id)
  ));
  
  return $data[0];
}

/*
***param Order_item id
*/
function get_product_id($order_item_id){
	$data = M\OrderItems::select('product_id')->where('id', $order_item_id)->first();
    return $data->product_id;
}

/*
*** param order_id
*/
function get_plant_id($order_id)
{
	$data = M\Orders::select('plant_id')->where('id', $order_id)->first();
	return $data->plant_id;

}


/*
*** param product_id
*/
function if_stock_available($product_id)
{
  
  $product = obj('products')->read([
    'select'  => ['unique_hash'],
    'where'   => ['id', $product_id]
  ]);
  
  $prod = M\Products::select('id','stock','plant_id')->where('id', $product_id)->where('unique_hash', $product[0]['unique_hash'])->where('plant_id', user_id())->first();  
  

  if(!$prod){
  	lib('flash')->set('global',array(
                            'type'  => 'danger',
                            'msg'   => "Unable to ship. Product is not available in your stock."
     ));

     redirect(current_url());
  }

	return $prod->stock;

}

function get_product_name($product_id){
	
	$product = obj('products')->read([
    'select'  => ['unique_hash'],
    'where'   => ['id', $product_id]
  ]);
  
  $prod = M\Products::select('product_name')->where('unique_hash', $product[0]['unique_hash'])->where('plant_id', user_id())->first();  

   if(!$prod){
  	lib('flash')->set('global',array(
                            'type'  => 'danger',
                            'msg'   => "Unable to ship. Product is not available in your stock."
     ));

     redirect(current_url());
  }

	return $prod->product_name;
}

function product_total_shipped_amount($product_id, $order_id){

	$ci = &get_instance();

	$query = "select sum(`shipped_items`.qty) as `qty` from shipped_items LEFT JOIN `order_items` on `shipped_items`.order_item_id=`order_items`.id where `order_items`.order_id ='".$order_id."' AND `order_items`.product_id='".$product_id."' Group BY `order_items`.product_id";

	$data =  $ci->db->query($query)->result_array();

	return isset($data[0]['qty']) ? $data[0]['qty'] : 0;
	
}