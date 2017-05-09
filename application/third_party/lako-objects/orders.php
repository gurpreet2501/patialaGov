<?php
lako::get('objects')->add_config('orders',array(
  "table"     => "orders",
  "name"      => "orders",
  "pkey"      => "id",
  "fields"    => array(),
  "relations" => array(
      "user" => array(
        "type"              => "M-1",
        "path"              => ["user_id","id"],
        "object"            => "users",
      ),
      
      "customer" => array(
        "type"              => "1-1",
        "path"              => ["id","order_id"],
        "object"            => "order_customer",
        "holds_foreign_key" => 0
      ),
      "items" => array(
        "type" => "1-M",
        "path" => ["id","order_id"],
        "object" => "order_items"
      ),
     "plant" => array(
        "type"              => "M-1",
        "path"              => ["plant_id","id"],
        "object"            => "users"
      ),
      "payment_details" => array(
        "type"              => "1-1",
        "path"              => ["id","order_id"],
        "object"            => "payment_details",
        "holds_foreign_key"   => 0
      ),
      "shpiment_export" => array(
        "type"              => "1-1",
        "path"              => ["id","order_id"],
        "object"            => "shipment_export",
        "holds_foreign_key"   => 0
      ) ,
      "shipment_domestic" => array(
        "type"              => "1-1",
        "path"              => ["id","order_id"],
        "object"            => "shipment_domestic",
        "holds_foreign_key"   => 0
      ), 
     "price_adjust" => array(
        "type"              => "1-1",
        "path"              => ["id","id"],
        "object"            => "price_adjust",
        "holds_foreign_key"   => 0
      ),
     "depots_orders" => array(
        "type"              => "N-M",
        "path"              => ["id",'order_id','depot_id',"id"],
        "connection_table"  => 'depots_orders',
        "object"            => "users"
      ),
     
   
  )
));