<?php
lako::get('objects')->add_config('depots_orders',array(
  "table"     => "depots_orders",
  "name"      => "depots_orders",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => [
  	'orders' => array(
      'type'    => '1-1',
      'path'    => ['order_id','id'],
      'object'  => 'orders'
		),
  	 
  ]
));