<?php

class lako_order_print extends lako_lib_base{
  protected $version = '0.01';
  protected $_p_items = [];
  function __construct($config=array()){
    parent::__construct($config);
    lako::import('order_item_print');
    foreach($config['items'] as $item){
      $this->_p_items[] = new lako_order_item_print($item);
    }
  }
  
  function id(){
    return $this->config['id'];
  }
  function date(){
    return date('g:i a - M j, Y',strtotime($this->config['date']));
  }
  
  function items(){
    return $this->_p_items;
  }
  
  function total(){
    $total = 0.00;
   
    foreach($this->items() as $item){
      $total += $item->subtotal();
    }
    return $total;  
  }
  
  function from_booking(){
    return intval($this->config['booking_id']);
  }
  
  public function payment_verified(){
    return intval ($this->config['payment_details']['verified']);
  }
  
  public function payment_receipt(){
    return (trim($this->config['payment_details']['receipt']))?$this->config['payment_details']['receipt']: '-';
  }
  
  
}