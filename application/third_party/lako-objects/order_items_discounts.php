<?php

lako::get('objects')->add_config('order_items_discounts',array(

  "table"     => "order_items_discounts",

  "name"      => "order_items_discounts",

  "pkey"      => "id",

  "fields"    => array(),

  "relations" => array(

    'prices' => array(

      'type'    => 'M-1',

      'path'    => ['price_id','id'],

      "object"  => "prices"

		),

    'products' => array(

      'type'    => '1-1',

      'path'    => ['product_id','id'],

      "object"  => "products"

		)

  )

));