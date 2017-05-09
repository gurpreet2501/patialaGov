<?php

lako::get('objects')->add_config('product_discounts',array(

  "table"     => "product_discounts",
  "name"      => "product_discounts",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'discount_types' => array(
      'type'    => 'M-1',
      'path'    => ['discount_id','id'],
      "object"  => "discount_types"
      ),
    )

));