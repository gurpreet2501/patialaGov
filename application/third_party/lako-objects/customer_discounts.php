<?php

lako::get('objects')->add_config('customer_discounts',array(
  "table"     => "customer_discounts",
  "name"      => "customer_discounts",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'discount_types' => array(
      'type'    => 'M-1',
      'path'    => ['discount_id','id'],
      'object'  => 'discount_types'
    ),
  )

));