<?php 

function cart_data(){
  $raw_data   = lako::get('cart')->get();
  $price_ids  = array_keys($raw_data);
  if(empty($price_ids))
    return array();
  
  $prices = lako::get('objects')->get('prices')->read(array(
              'select' => array('^*','products.product_name','products.image'),
              'where' => array('id','IN', $price_ids),
            ));
  $total = 0;
  foreach($prices as $price){
    $raw_data[$price['id']]['data'] = $price;
    $raw_data[$price['id']]['subtotal'] = $price['price']*$raw_data[$price['id']]['qty'];
    $total +=  $raw_data[$price['id']]['subtotal'];
  }
  return array(
    'products'  => $raw_data,
    'total'     => $total
  );
} 
