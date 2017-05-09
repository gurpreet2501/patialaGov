<?php

lako::get('objects')->add_config('district_target',array(
  "table"     => "district_target",
  "name"      => "district_target",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => [
    'category' => [
      "type"                => "1-1",
      "path"                => ["category","id"],
      "object"              => "categories",
      "holds_foriegn_key"   => 1
    ],
    'district' => [
      "type"                => "M-1",
      "path"                => ["district_id","id"],
      "object"              => "district"
    ],
  ]

));