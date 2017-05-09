<?php
lako::get('objects')->add_config('booking',array(
  "table"     => "booking",
  "name"      => "booking",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array("items" => array(
    "type"    => "1-M",
    "path"    => ["id","booking_id"],
    "object"  => "booking_items"
  ))
));