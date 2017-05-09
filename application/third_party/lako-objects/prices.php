<?php
lako::get('objects')->add_config('prices',array(
  "table"     => "prices",
  "name"      => "prices",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'products' => array(
      'type'    => 'M-1',
      'path'    => ['product_id','id'],
      "object"  => "products"
		)
  )
));