<?php

lako::get('objects')->add_config('district',array(
  "table"     => "district",
  "name"      => "district",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => [
    'district_target' => [
      "type"    => "1-M",
      "path"    => ["id","district_id"],
      "object"  => "district_target"
    ],
    'customer_targets' => [
      "type"    => "1-M",
      "path"    => ["id","district_id"],
      "object"  => "customer_targets"
    ]
  ]

));