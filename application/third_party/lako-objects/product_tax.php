<?php

lako::get('objects')->add_config('product_tax',array(

  "table"     => "product_tax",
  "name"      => "product_tax",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'tax_types' => array(
      'type'    => 'M-1',
      'path'    => ['tax_id','id'],
      "object"  => "tax_types"
    )
  )

));