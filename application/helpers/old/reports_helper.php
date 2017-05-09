<?php
use App\Models as M;
function get_cats_from_targets($targets){
  $cats = [];
  foreach($targets as $target)
    foreach($target['district_target'] as $cat)
      $cats[$cat['category']['id']] = $cat['category'];
  return $cats;
}

function fill_report_categories($dist_target, $cats ,$orders){
  $sales = [];
  foreach($cats as $cat){
    $sale = [
      'target'      => 0,
      'sale'        => 0,
      'percentage'  => 0
    ];
    if($target = cat_in_target($dist_target['district_target'],$cat)){
      $sale['sale'] = weight_ordered_in_district($target['district_id'],$target['category']['id'],$target['weight_unit'], $orders);
      $sale['target'] = number_format($target['target'],2) .' '. $target['weight_unit'];
      $sale['percentage'] = number_format((floatval($sale['sale'])/floatval($target['target'])) * 100,2).'%';
      $sale['sale'] = number_format($sale['sale'],2) .' '. $target['weight_unit'];
    }
    $sales[$cat['id']] = $sale;
  }
  return $sales;
}

function weight_ordered_in_district($district_id,$category_id,$weight_unit,$orders){

  get_instance()->load->helper('unit');
  $weight = 0;

  foreach($orders as $order){
    if($order['user']['district']['id'] != $district_id)
      continue;
    
    foreach($order['items'] as $item){
      if($item['product']['category'] != $category_id)
        continue;
      $weight += convert_weight($item['weight_unit'],$weight_unit,$item['weight']*$item['qty']);
    }
  }
  return $weight;
}


function cat_in_target($dist_targets,$cat){
  foreach($dist_targets as $target)
    if($target['category']['id'] == $cat['id'])
      return $target;
  return false;
}

function make_customer_target_report_friendly(&$dist_targets){
  $temp = [];
  foreach($dist_targets as $tk => $target){
    $disctrict_id = $target['customer']['district']['id'];
    
      $target['district_id'] = $disctrict_id;
      
    if(!isset($temp[$disctrict_id])){
      $temp[$disctrict_id] = $target['customer']['district'];
      $temp[$disctrict_id]['district_target'] = [];  
    }
    
    unset($target['customer']);
    
    $temp[$disctrict_id]['district_target'][] = $target;
  }
    
  $dist_targets = $temp;
}

function soryArray($a, $b){
  if ($a['time'] == $b['time']) {
        return 0;
    }
    return ($a['time'] < $b['time']) ? -1 : 1;
}

function generate_country_wise_report($resp){

    $obj =& get_instance();
    $data = [];
 
    // Making Country name as key
    foreach ($resp as $key => $val) {
      $block =[];
      $time = strtotime(date('Y-m-d', strtotime($val['date_of_dispatch'])));
      $block['party_name'] = $val['party_name'];
      $block['date_of_dispatch'] = $val['date_of_dispatch'];
      $block['invoice_no'] = $val['invoice_no'];
      $block['order_no'] = $val['order_no'];
      $block['time'] = $time;
      $data[$val['country']][] = $block;
    }
  
      //Array sorting and reversing  
     foreach ($data as $key => $val) {
        usort($data[$key], function($a, $b){
            if ($a['time'] == $b['time']) {
              return 0;
          }
          return ($a['time'] < $b['time']) ? -1 : 1;
       });

       $data[$key] = array_reverse($data[$key]);
     }
    

     $invoiceDump = []; 
     $filtered = []; 

     foreach ($data as $country => $invoices) {
       foreach ($invoices as $key => $singleInvoice) {
         if(in_array($singleInvoice['invoice_no'], $invoiceDump))
             continue;
         $invoiceDump[] = $singleInvoice['invoice_no'];
         $filtered[$country][$key] = $singleInvoice;
       }
       $invoiceDump = [];
     }

    $filter = [];
    
    // Making Party name as key
    foreach ($filtered as $country => $val) {
        foreach ($val as $key => $v) {
          $block = [];
          $block['date_of_dispatch'] =   $v['date_of_dispatch'];
          $block['invoice_no'] =   $v['invoice_no'];
          
          if(!isset($filter[$country][$v['party_name']]))
            $filter[$country][$v['party_name']] = [];

          $filter[$country][$v['party_name']][] = $block;
          
        }   

    }
 
    $final = [];
    // Making Date as key
    foreach ($filter as $country => $val) {
      foreach ($val as $company => $dates) {
         foreach ($dates as $key => $date) {
             $modDate = date('Y-m-d', strtotime($date['date_of_dispatch']));
             $invoice_no = trim($date['invoice_no']);
             $final[$country][$company][$modDate][$invoice_no]['date_of_dispatch'] = $date['date_of_dispatch'];
             
         } 
      }
    }
    
    return $final;
}


function generate_month_wise_report($resp){

    $data = [];
    foreach ($resp as $key => $val) {
        $time = strtotime(date('Y-m-d', strtotime($val['date_of_dispatch'])));
        $data[] = [
          'time' => $time,
          'invoice' => $val['invoice_no'],
        ]; 
    }

    usort($data,function($a, $b){

      if($a['time'] == $b['time'])
        return 0;
      return ($a['time'] < $b['time']) ? -1 : 1;
    });

    $data = array_reverse($data);

    $indexed = [];
    $accountedFor = [];
    foreach($data as $val){
      if(in_array($val['invoice'], $accountedFor))
        continue;

      $accountedFor[] = $val['invoice'];

      $str = date('Y-m', $val['time']);

      if(!isset($indexed[$str]))
        $indexed[$str] = [];
      $indexed[$str][] = $val['invoice'];
    }

    return array_reverse($indexed);
}


function keep_plant_targets(&$targets, $plant_id){
  foreach($targets as $tk => $target)
    foreach($target['district_target'] as $dtk => $district_target)
      if($district_target['user_id'] != $plant_id)
        unset($targets[$tk]['district_target'][$dtk]);
}

