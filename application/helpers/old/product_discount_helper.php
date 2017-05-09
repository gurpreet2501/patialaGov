<?php 
use App\Models;
function calculate_discount($quant, $pid, $_pprice){
  
  $calculated_discounts = [];
  $total_discount       = 0.00;
  $pprice               = floatval($_pprice);

  foreach(applied_discounts($quant, $pid, user_id()) as $discount_config){
   
    $discount = [
      'discount_title'  => $discount_config['discount_types']['discount_title'],
      'discount_amount' => 0.00,
      'calculation'     => '0.00%',
      'discount_type'   => $discount_config['discount_type']
    ];
  
    $discount_amount  = is_export_user() ? floatval($discount_config['export_discount']) : floatval($discount_config['discount']);
    
    // $currency_symbol = is_export_user() ? '$' : 'Rs.';

    if($discount_config['discount_type'] == 'Percentage Based'){
      $discount['discount_amount'] = (($discount_amount/100)*$pprice)*$quant;
      $discount['calculation'] = "$discount_amount%";
    }else{
      $discount['discount_amount'] = $discount_amount*$quant;
      $discount['calculation'] = "{$discount_amount}";
    }


    $calculated_discounts[] = $discount;
    $total_discount += $discount['discount_amount'];
  }
  $dis['calculated_dis']  = $calculated_discounts;
  $dis['tot_dis']         = $total_discount;

  return $dis;
}

function applied_discounts($quant, $pid, $user_id){
  
  $customer_discounts = [];
  $res = Models\CustomerDiscounts::where('customer_id', $user_id)->where('product_id',$pid)->get();
  foreach ($res as $key => $discount) {

    if(!$discount)
      continue;

    $customer_discounts[$key] = $discount->toArray();

    if(!$discount->discountTypes){
       $customer_discounts[$key]['discount_types'] = [
        'discount_title' => ''
       ];  
       continue;
    }

    $customer_discounts[$key]['discount_types'] =  $discount->discountTypes->toArray();    
    
  }
  
   $discounts = $customer_discounts;
   if(empty($customer_discounts))
    $discounts = $product_discounts = obj('product_discounts')
                                          ->read(['select' =>  ['^*','discount_types.discount_title'],
                                                  'where'  =>  ['product_id',$pid]]);
  
  $applied_discounts = [];
 
  foreach($discounts as $discount_config){
    $minimum_qty      = intval($discount_config['quantity']);
    if($quant < $minimum_qty)
      continue;

    $applied_discounts[] = $discount_config;
  }
  
  return $applied_discounts;
  
}

function calculate_booking_discount($quant, $pid, $_pprice , $booking_id){
  $calculated_discounts = [];
  $total_discount       = 0.00;
  $pprice               = floatval($_pprice);
  $booking = obj('booking_items')->read([
    'select'  => ['id','discounts.^*'],
    'where'   => [['product_id',$pid],'AND',['booking_id',$booking_id]]
  ]);

  if(empty($booking))
    return [];

  $discounts = $booking[0]['discounts'];
  
  
  foreach($discounts as $discount_config){
    $discount = [
      'discount_title'  => $discount_config['title'],
      'discount_amount' => 0.00,
      'calculation'     => '0.00%',
      'discount_type'   => $discount_config['type']
    ];
    
    $discount_amount  = floatval($discount_config['amount']);
    
    if($discount_config['type'] == 'Percentage Based'){
      $discount['discount_amount'] = (($discount_amount/100)*$pprice)*$quant;
      $discount['calculation'] = "$discount_amount%";
    }else{
      $discount['discount_amount'] = $discount_amount*$quant;
      $discount['calculation'] = "Rs. {$discount_amount}";
    }
    $calculated_discounts[] = $discount;
    $total_discount += $discount['discount_amount'];
  }
   
  $dis['calculated_dis']  = $calculated_discounts;
  $dis['tot_dis']         = $total_discount;

  return $dis;
}
