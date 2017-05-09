<?php
use App\Models;
function plant_settings($key = false){
  global $__plant_settings;

  if(!$__plant_settings){
    $__plant_settings = obj('store_settings')->read(['select' => ['^*'],
                                                     'where'  => ['plant_id', plant()]]);
    $__plant_settings = isset($__plant_settings[0]) ? $__plant_settings[0] : '';
  }

  if($key){
    if(isset($__plant_settings[$key]))
      return $__plant_settings[$key];
    return null;
  }
  return $__plant_settings;
}

function plant($var = 'id'){
  global $plant;
  if($plant)
    return $plant[$var];

  if(($plant = lako::get('session')->get('plant')))
    return $plant[$var];
  return '';
}

function plant_set($in_plant){
  global $plant;
  $plant = $in_plant;
  lako::get('session')->set('plant',$in_plant);
  redirect('home');
}

function plant_set_by_id($in_plant_id, &$status){
  $plants = obj('users')->read(['select' => ['full_name','id'],
                               'where'  => ['id',$in_plant_id]]);
  $status = true;
  if(empty($plants)){
    $status = false;
    return;
  }
  return plant_set($plants[0]);
}

function get_plants_which_can_do_export(){
  $plants = Models\PlantsConfiguration::select('plant_id')->where('value',1)->where('key','can_do_export')->get();
  
  $ids = [];
  if(empty($plants))
    return $ids;

  foreach($plants as $val)
    $ids[] = $val ->plant_id;

  return $ids;
  
}

function plant_categories(){
  $plant_id = plant();
  if(!$plant_id)
    return array();
  return obj('categories')->read(array(
          'select'  => array('^*'),
          'where'   => array('added_by', $plant_id)
         ));
}

function plant_id_to_name($id){
  $plant = Models\Users::select('full_name')->where('id',$id)->first();
  return isset($plant->full_name) ? $plant->full_name : '';
}

function plant_home_func($id=0){
  $p_id = $id;
  if(!$id)
    $p_id = plant();
  return 'home_'.plant_id_to_name($p_id);
}

function current_user_price($product){
  $user_cat = user_category();
  foreach($product['customer_category_price'] as $cat){
    if($cat['customer_category_id'] == $user_cat->id)
      return $cat['price'];
  }

  return $product['price'];
}

function get_plants_list(){
    return obj('users')->read(array(
          'select'  => array('id','username','capability'),
          'where'   => array('role','plant_manager')
    ));
}

function plant_force(){
  if(!plant())
    redirect('plant');
}

function check_plant_conf_key_value($id, $key){

  $data = Models\PlantsConfiguration::select('value')->where('plant_id', $id)->where('key', $key)->first();
  
  return isset($data->value) ? $data->value : 0;
  
}


function read_plants_configuration(){

  $data = Models\PlantsConfiguration::get();
  
  return isset($data->value) ? $data->value : 0;
  
}

function get_depots_that_can_share_orders(){

  $data = Models\PlantsConfiguration::where('plant_id','!=',user_id())->where('key','can_accept_shared_orders')->where('value',1)->with("plantName")->get()->toArray();

  return !empty($data) ? $data : [];
  
}

function get_depots_that_can_accept_forward_orders(){

  $data = Models\PlantsConfiguration::where('plant_id','!=',user_id())->where('key','can_accept_forward_orders')->where('value',1)->with("plantName")->get()->toArray();

  return !empty($data) ? $data : [];
  
}

function has_capability($key){

  $data = Models\PlantsConfiguration::select('value')->where('key',$key)->where('plant_id', user_id())->first();
 
  return $data['value'];

  
}

function can_accept_domestic_order_mig(){
     
      $data = Models\Users::select('id','username','capability')->where('role','plant_manager')->get();
        
        if(empty($data))
            return;

         $record = [];
          foreach ($data as $key => $value) {
            $record['plant_id'] = $value->id;
            $record['key'] = 'can_accept_domestic_order';

            $record['value'] = (($value->username == 'khanna') || ($value->username == 'jalandhar') || ($value->username == 'nawanshahr')) ? 0 : 1;

            Models\PlantsConfiguration::create($record);

          }
}


function current_plant_order($order_id){
  $ci = &get_instance();
  $user = Models\Orders::select('user_id')->where('id', $order_id)->first();
  return ($user->user_id == $ci->tank_auth->get_user_id()) ? 1 : 0;
}

function get_plant_name_from_order_no($order_id){
  $ci = &get_instance();
  $plant = Models\Orders::select('plant_id')->where('id', $order_id)->first();
  $user = Models\Users::where('id', $plant->plant_id)->first();
  $suffix = 'plant';
  
  if(user_id() == $plant->plant_id)
    return "Shared Order";

  if(!$user)
    return 'Shared Order';

  if($user->capability == 'depot')
    $suffix = 'depot';

  $str = 'Order shared by: '.$user->username.' '.$suffix;

  return ucfirst($str);
  
  
}