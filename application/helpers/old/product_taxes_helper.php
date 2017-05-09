<?php 
function calculate_taxes($quant, $pid, $_pprice){ // 3 parameters (quantity, product_id , price)
    $pprice = floatval($_pprice);
    $calculated_tax = [];
    $total_tax = 0.00;
    
    foreach(applied_taxes($quant, $pid, user_id()) as $tax_config){
      
      $tax = [
        'tax_title'    => $tax_config['tax_types']['tax_title'],
        'tax_amount'   => 0.00,
        'calculation'  => '0.00%',
        'tax_type'     => $tax_config['tax_type']
      ];
      
      $tax_amount			  = floatval($tax_config['tax']);
      
      if($tax_config['tax_type'] == 'Percentage Based'){

        $tax['tax_amount'] = (($tax_amount / 100) * $pprice) * $quant;
        $tax['calculation'] = "$tax_amount%";

      }else{

        $tax['tax_amount'] = $tax_amount*$quant;
        $tax['calculation'] = "Rs. {$tax_amount}";

      }

      $calculated_tax[] = $tax;
      
      $total_tax += $tax['tax_amount'];
    }
  
   $taxes['calculated_tax'] =  $calculated_tax;
   $taxes['total_tax'] =  $total_tax;
    
  return $taxes;
    
}

function applied_taxes($quant, $pid, $user_id){
  $taxes = $customer_tax = obj('customer_tax')->read(['select' =>  ['^*','tax_types.tax_title'],
                                                    'where'  =>  ['customer_id',$user_id],
                                                                  'AND',
                                                                 ['product_id',$pid]]);
  if(empty($customer_tax))
    $taxes = $product_tax = obj('product_tax')->read(['select' =>  ['^*','tax_types.tax_title'],
                                                    'where'  =>  ['product_id',$pid]]);
     
   
  $applied_taxes = [];
  foreach($taxes as $tax_config){
    $minimum_qty      = intval($tax_config['quantity']);
    
    if($quant < $minimum_qty)
      continue;
    $applied_taxes[] = $tax_config;
  }
  return $applied_taxes;
}



function calculate_booking_taxes($quant, $pid, $_pprice,$booking_id){ // 3 parameters (quantity, product_id , price)
    $pprice = floatval($_pprice);
    $calculated_tax = [];
    $total_tax = 0.00;
    
    $booking = obj('booking_items')->read([
      'select'  => ['id','taxes.^*'],
      'where'   => [['product_id',$pid],'AND',['booking_id',$booking_id]]
    ]);
    if(empty($booking))
      return [];
    $taxes = $booking[0]['taxes'];
     
    foreach($taxes as $tax_config){
      
      $tax = [
        'tax_title'    => $tax_config['title'],
        'tax_amount'   => 0.00,
        'calculation'  => '0.00%',
        'tax_type'     => $tax_config['type']
      ];
      
      $tax_amount			  = floatval($tax_config['amount']);
      
      if($tax_config['type'] == 'Percentage Based'){

        $tax['tax_amount'] = (($tax_amount / 100) * $pprice) * $quant;
        $tax['calculation'] = "$tax_amount%";

      }else{

        $tax['tax_amount'] = $tax_amount*$quant;
        $tax['calculation'] = "Rs. {$tax_amount}";

      }

      $calculated_tax[] = $tax;
      
      $total_tax += $tax['tax_amount'];
    }
  
   $taxes['calculated_tax'] =  $calculated_tax;
   $taxes['total_tax'] =  $total_tax;
    
  return $taxes;
    
}




