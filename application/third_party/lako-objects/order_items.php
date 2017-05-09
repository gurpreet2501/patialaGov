<?php

lako::get('objects')->add_config('order_items',array(
  'table'     => 'order_items',
  'name'      => 'order_items',
  'pkey'      => 'id',
  'fields'    => array(),
  'relations' => array(
 
    
	  'discounts' => array(
      'type'    => '1-M',
      'path'    => ['id','order_item_id'],
      'object'  => 'order_items_discounts'
		),
    
		'taxes' => array(
      'type'    => '1-M',
      'path'    => ['id','order_item_id'],
      'object'  => 'order_items_taxes'
		),
  )
));