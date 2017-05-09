<?php

function current_user_bookings(){
  return obj('booking')->read(array(
     'select'  => ['id'],
     'where'   => array('user_id',user_id()),
   ));
}

function book_order(&$products, &$status){
  get_instance()->load->helper('product_discount');
  get_instance()->load->helper('product_taxes');
  
  $items = [];
  foreach($products as $product_id => $details){
    if(!intval($details['qty']))
      continue;
    
    $discounts  = applied_discounts($details['qty'],$product_id, user_id());
    $taxes      = applied_taxes($details['qty'], $product_id, $details['price']);
    format_booking_discounts($discounts);
    format_booking_taxes($taxes);
    
    $items[] = [
      'product_id'        => $product_id,
      'total_quantity'    => $details['qty'],
      'price'             => $details['price'],
      'remaining_qty'     => $details['qty'],
      'discounts'         => $discounts,
      'taxes'             => $taxes,
    ];
    
    reduce_product_stock($product_id,$details['qty']);
  }
  if(empty($items)){
    $status = false;
    return null;
  }
  $booking = [
    'user_id'   => user_id(),
    'plant_id'  => plant(),
    'date'      => date('Y-m-d H:i:s'),
    'days'      => plant_settings('booking_duration'),
    'items'     => $items
  ];
  

  try{
    $insert_booking = obj('booking')->insert($booking);
  }catch(Exception $e){
    $status = false;
    return;
  }
  return $insert_booking['booking'];
}


function format_booking_taxes(&$taxes){
  foreach($taxes as $key => $tax){
    $taxes[$key] = [
      'title'   => $tax['tax_types']['tax_title'],
      'amount'  => $tax['tax'], 
      'type'    => $tax['tax_type']
    ];
  }
}
function format_booking_discounts(&$discounts){
  foreach($discounts as $key => $discount){
    $discounts[$key] = [
      'title'   => $discount['discount_types']['discount_title'],
      'amount'  => $discount['discount'], 
      'type'    => $discount['discount_type']
    ];
  }
}

function booking_details($booking_id){
  $select = array('^*','items.^*',
	  'items.product.product_name',
	  'items.product.image',
	  'items.product.weight',
	  'items.product.weight_unit',
  );
  
  $booking = obj('booking')->read(array(
     'select'  => $select,
     'where'   => array('id', $booking_id)
   ));
  if(empty($booking))
    return false;
  return $booking[0];
}



function get_product_price($p_id){
  $product_price = lako::get('objects')->get('prices')->read(array(
      'select'   => array('price'),
      'where'    => array('product_id',$p_id)
   	));
  return $product_price[0]['price'];
}

function template_compatible_booking($booking){
  $products = [];
  foreach($booking['items'] as $booked_product){
    $products[] = [
      'id'              => $booked_product['product_id'],
      'booking_item_id' => $booked_product['id'],
      'stock'           => $booked_product['remaining_qty'],
      'price'           => $booked_product['price'],
      'image'           => $booked_product['product']['image'],
      'product_name'    => $booked_product['product']['product_name'],
      'weight'          => $booked_product['product']['weight'],
      'weight_unit'     => $booked_product['product']['weight_unit'],
    ];
  }
  return $products;
}


function reduce_booking_product_stock($product_id, $booking_id, $by){
  $row = obj('booking_items')->read([
    'select'  => ['id','remaining_qty'],
    'where'   => [['product_id',$product_id],'AND',['booking_id',$booking_id]]
  ]);
  if(empty($row))
    return;
  $stock = $row[0]['remaining_qty'];
  return obj('booking_items')->update(
    ['remaining_qty'  => $stock-intval($by)],
    ['id',$row[0]['id']]
  );
}
