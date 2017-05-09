<?php

lako::get('objects')->add_config('export_orders',array(
  "table"     => "export_orders",
  "name"      => "export_orders",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => [
  	'orders' => array(
      'type'    => '1-M',
      'path'    => ['id','export_order_id'],
      'object'  => 'orders'
		),
  	
  ]

));