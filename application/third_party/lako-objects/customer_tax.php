<?php

lako::get('objects')->add_config('customer_tax',array(

  "table"     => "customer_tax",
  "name"      => "customer_tax",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    'tax_types' => array(
      'type'    => 'M-1',
      'path'    => ['tax_id','id'],
      "object"  => "tax_types"
    ),
  )

));