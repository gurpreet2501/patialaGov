<?php
lako::get('objects')->add_config('users',array(
  "table"     => "users",
  "name"      => "users",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
      "booking" => array(
        "type" => "1-M",
        "path" => ["id","booking_id"],
        "object" => "booking"
      ),
    "district" => array(
        "type" => "M-1",
        "path" => ["district","id"],
        "object" => "district"
      ),
    "customer_category" => [
      "type"    => 'M-1',
      "path"    => ["category","id"],
      "object"  => "customer_categories"
    ]
   )
));