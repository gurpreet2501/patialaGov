<?php

lako::get('objects')->add_config('customer_targets',array(
  "table"     => "customer_targets",
  "name"      => "customer_targets",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => [
    'category' => [
      "type"   => "M-1",
      "path"   => ["category_id","id"],
      "object" => "categories"
    ],
    'customer' => [
      "type"   => "M-1",
      "path"   => ["customer_id","id"],
      "object" => "users"
    ],
  ]
));