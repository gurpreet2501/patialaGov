<?php

lako::get('objects')->add_config('products',array(

  "table"     => "products",
  "name"      => "products",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'discounts' => array(
      'type'  => '1-M',
      'path'  => ['id','product_id'],
      "object" => "discounts"
		),

    'plant' => array(
      'type'  => 'M-1',
      'path'  => ['plant_id','id'],
      "object" => "users"
		),

    'categories' => array(
      'type'  => '1-1',
      'path'  => ['category','id'],
      "object" => "categories"
		),
   'district_target' => array(
      'type'  => '1-1',
      'path'  => ['category','category'],
      "object" => "district_target"
    ),
   'customer_category_price' => array(
      'type'  => '1-M',
      'path'  => ['id','product_id'],
      "object" => "customer_category_product_price"
		),


  )

));