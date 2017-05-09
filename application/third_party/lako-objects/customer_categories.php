<?php
lako::get('objects')->add_config('customer_categories',array(
  "table"     => "customer_categories",
  "name"      => "customer_categories",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'customer_category_product_price' => array(
      'type'    => '1-1',
      'path'    => ['id','customer_category_id'],
      'object'  => 'customer_category_product_price'
    )

)));