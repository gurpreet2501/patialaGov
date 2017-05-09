<?php

class lako_order_item_print extends lako_lib_base{
  protected $version = '0.01';
  protected $taxes = [];
  protected $discounts = [];
  function __construct($config=array()){
    parent::__construct($config);
    foreach($config['taxes'] as $tax)
      $this->taxes[] = $this->build_tax($tax);
      
    foreach($config['discounts'] as $discount)
      $this->discounts[] = $this->build_discount($discount);
  }
  
  
  function build_discount($discount){
    return $this->build_tax($discount);
  }
  

  
  function build_tax($tax){
    $tax['amount'] = floatval($tax['amount']);
    if($tax['type'] == 'Percentage Based')
      $item_tax = ($tax['amount']/100)*$this->single_price();
    else
      $item_tax = $tax['amount'];
    
    $tax['total_amount'] = $item_tax*$this->qty();
    return $tax;
  }
  
  function qty(){
    return intval($this->config['qty']);
  }
  
  function single_price(){
    return is_export_user() ? floatval($this->config['export_price']) : floatval($this->config['price']);
  }
  
  function total_price(){
    return $this->single_price()*$this->qty();
  }
  
  function taxes_total(){
    $tax_total = 0;
    foreach($this->taxes as $tax)
      $tax_total += $tax['total_amount'];
    return $tax_total;
  }
  
  function discounts_total(){
    $discounts_total = 0;
    foreach($this->discounts as $discount)
      $discounts_total += $discount['total_amount'];
    return $discounts_total;
  }
  
  function subtotal(){
    return $this->total_price()+$this->taxes_total()-$this->discounts_total();
  }
  
  function product_name(){
    return $this->config['product_name'];
  }
  
  function product_name_with_weight(){
    return $this->product_name()." ({$this->config['weight']} {$this->config['weight_unit']}) ";
  }
}