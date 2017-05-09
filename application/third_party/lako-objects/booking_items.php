<?php
lako::get('objects')->add_config('booking_items',array(
  "table"     => "booking_items",
  "name"      => "booking_items",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
    "product" => array(
      "type"                => "1-1",
      "path"                => ["product_id","id"],
      "object"              => "products",
      "holds_foreign_key"   => 1
    ),
    "discounts" => array(
      "type"                => "1-M",
      "path"                => ["id","booking_item_id"],
      "object"              => "booking_items_discounts"
    ),
    "taxes" => array(
      "type"                => "1-M",
      "path"                => ["id","booking_item_id"],
      "object"              => "booking_items_taxes"
    )
  )
));