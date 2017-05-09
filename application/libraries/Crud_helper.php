<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
use Illuminate\Database\Eloquent\Model;

class Crud_helper{
  
  function __construct(){}
  
  //**** Record Activity ****//
  public static function record_activity(&$crud){
    self::created_at($crud);
    self::updated_at($crud);
  }
    public static function created_at(&$crud){
      $crud->callback_before_insert('Crud_helper::add_created_at');
      $crud->change_field_type('created_at','hidden');
    }
    
      public static function add_created_at($data){
        if(isset($data['created_at']))
          $data['created_at'] = date('Y-m-d H:i:s');
        return $data;
      }
    
    public static function updated_at(&$crud){
      $crud->callback_before_update('Crud_helper::add_updated_at');
      $crud->change_field_type('updated_at','hidden');
    }
    
      public static function add_updated_at($data,$pkey){
        if(isset($data['updated_at']))
          $data['updated_at'] = date('Y-m-d H:i:s');
        return $data;
      }
  
  //**** Record Activity ****//
  
  
  //**** Product Discount Management ****//
  public static function product_discount_field($value='', $pkey=0){
    return '<p>'.
            '<a href="'.site_url("manage/discount/product/{$pkey}").'" class="fancy iframe">Manage Discounts</a>'.
          '</p>';
  }
  public static function set_district_target($value='', $pkey=0){
    return '<p>'.
            '<a href="'.site_url("manage/district/target/").'" class="fancy iframe">Set District Target</a>'.
          '</p>';
  }
  //**** Product Discount Management ****//
  
  
  //**** Product Tax Management ****//
  public static function product_tax_field($value='', $pkey=0){
    return '<p>'.
            '<a href="'.site_url("manage/tax/product/{$pkey}").'" class="fancy iframe">Manage Tax</a>'.
          '</p>';
  }
  //**** Product Tax Management ****//
  
  
  //**** Customer Discount Management ****//
  public static function customer_discount_field($value='', $pkey=0){
    return '<a href="'.site_url("manage/discount/customer/{$pkey}").'" class="fancy iframe">Click here to Manage Discounts</a>
            <br/>
            <br/>
             <b>NOTE: If you add any discounts specific to one customer for a product. <br />
              Only Customer specific discounts will be considered. Discounts added under  <br />
              "Manage Products" section will not be applicable.</b>';
  }
  //**** Customer Discount Management ****//
  
  //**** Customer Discount Management ****//
  public static function customer_tax_field($value='', $pkey=0){
    return '<a href="'.site_url("manage/tax/customer/{$pkey}").'" class="fancy iframe">Click here to Manage Tax</a>
            <br/>
            <br/>
             <b>NOTE: If you add any taxes specific to one customer for a product. <br />
              Only Customer specific taxes will be considered. Taxes added under  <br />
              "Manage Products" section will not be applicable.</b>';
  }
  //**** Customer Discount Management ****//
  
  //**** Customer target Management ****//
  public static function customer_targets_field($value='', $pkey=0){
    return '<p>'.
            '<a href="'.site_url("manage/targets/customer/{$pkey}").'" class="fancy iframe">
              Manage Targets
            </a>'.
           '</p>';
  }
  //**** Customer target Management ****//
  
  
  //**** Custom Fancy Box ****//
  public static function install_full_fancybox(&$output){
    $fancy_box_js = base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js');
    $fancy_box_init_js = base_url('assets/js/init-fancybox.js');
    $fancy_css = base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css');
    $output->js_files[md5($fancy_box_js)] = $fancy_box_js;
    $output->js_files[md5($fancy_box_init_js)] = $fancy_box_init_js;
    $output->css_files[md5($fancy_css)] = $fancy_css;
  }
  //**** Custom Fancy Box  ****//
  
  
  //******* general unset print export view *******//
  public static function disable_pev(&$crud){
    $crud->unset_export();
    $crud->unset_print();
    $crud->unset_read();
  }
  //******* general unset print export view *******//
  
  
  //******* delete category *******//
  public static function delete_category($id){
    $district_target = obj('district_target')->count(['where'=>['category',$id]]);
    if($district_target)
      return false;
    
    $customer_target = obj('customer_targets')->count(['where'=>['category_id',$id]]);
    if($customer_target)
      return false;
    
    $products = obj('products')->count(['where'=>['category',$id]]);
    if($products)
      return false;
    
    return get_instance()->db->delete('categories', array('id' => $id));
  }
  //******* general unset print export view *******//
  
   //******* delete customer category *******//
  public static function delete_customer_category($primary_key){

    $cus_cat = obj('users')->count(['where'=>['category',$primary_key]]);
    
    if($cus_cat)
      return false;
    
    return get_instance()->db->delete('customer_categories', array('id' => $primary_key));
  }

  
  //******* delete category *******//
  public static function delete_product($id){

    $product = obj('products')->read($id);

    $image_file = BASEPATH.'../assets/uploads/files/'.$product[0]['image'];
    if(file_exists($image_file))
      @unlink($image_file);
    
    $obj = Models\Products::find($id);

    $products = Models\Products::where('unique_hash', $obj->unique_hash)->get();
    foreach ($products as $key => $product) {
      $product->delete();
    }

    // get_instance()->db->delete('products', array('id' => $id));
    // get_instance()->db->delete('customer_category_product_price', array('product_id' => $id));
    return true;
  }
  //******* general unset print export view *******//
  
  //******* delete category *******//
  public static function delete_customer($id){
    $orders = obj('orders')->count(['where'=>['user_id',$id]]);
    if($orders)
      return false;
    
    $booking = obj('booking')->count(['where'=>['user_id',$id]]);
    if($booking)
      return false;
    
    get_instance()->db->delete('customer_tax', array('customer_id' => $id));
    get_instance()->db->delete('customer_discounts', array('customer_id' => $id));
    get_instance()->db->delete('customer_targets', array('customer_id' => $id));
    get_instance()->db->delete('users', array('id' => $id));
    return true;
  }
  //******* general unset print export view *******//
  
  //******* delete category *******//
  public static function delete_discount_type($id){
    $c_d = obj('customer_discounts')->count(['where'=>['discount_id',$id]]);
    if($c_d)
      return false;
    
    $p_d = obj('product_discounts')->count(['where'=>['discount_id',$id]]);
    if($p_d)
      return false;
    
    return get_instance()->db->delete('discount_types', array('id' => $id));;
  }
  //******* general unset print export view *******//
  
  //******* delete category *******//
  public static function delete_tax_type($id){
    $c_d = obj('customer_tax')->count(['where'=>['tax_id',$id]]);
    if($c_d)
      return false;
    
    $p_d = obj('product_tax')->count(['where'=>['tax_id',$id]]);
    if($p_d)
      return false;
    
    return get_instance()->db->delete('tax_types', array('id' => $id));;
  }
  //******* general unset print export view *******//
  
  
}


