<?php

lako::get('objects')->add_config('order_items_taxes',array(

  "table"     => "order_items_taxes",

  "name"      => "order_items_taxes",

  "pkey"      => "id",

  "fields"    => array(),

  "relations" => array(

    'prices' => array(

      'type'    => 'M-1',

      'path'    => ['price_id','id'],

      "object"  => "prices"

		)

   
  )

));