<?php

function is_role($role){
  return ($role == user_role() );
}

function user_role(){

  global $user_role;
  if($user_role)
    return $user_role;

  if(!logged_in()){
    $user_role = 'guest';
    return $user_role;
  }

	$ci = get_instance();
	$status=lako::get('objects')->get('users')->read(array(
    'select'  => array('role'),
    'where'   => array('id',$ci->tank_auth->get_user_id())
		));
  
  $user_role = $status[0]['role'];
  return $status[0]['role'];
}


function get_customer_details(){
  $ci = get_instance();
  $data = lako::get('objects')->get('users')->read(array(
        'select'  => array('full_name','customer_type','email','country','state','city','zip_code','category','address_line_1','address_line_2'),
        'where'   => [
             array('id', $ci->tank_auth->get_user_id()),
             'AND',
             array('role', 'customer'),

        ]

      ));

  return $data[0];

}

function is_export_user(){
  $ci=get_instance();
  $type = lako::get('objects')->get('users')->read(array(
    'select'  => array('customer_type', 'role'),
    'where'   => array('id',$ci->tank_auth->get_user_id())
    ));
  if(empty($type))
    return false;
  if(($type[0]['customer_type'] == 'Export') && $type[0]['role'] == 'customer')
    return true;
  
  return false;

}


function user_data($key = false){
  if(!logged_in())
    return null;

  global $_user_data;

  if(!$_user_data){
    $_user_data = lako::get('objects')->get('users')->read(user_id());
    $_user_data = $_user_data[0];
  }

  if(!$key)
    return $_user_data;
  elseif(!isset($_user_data[$key]))
    return null;
  else
    return $_user_data[$key];
}


function user_category(){
  $default_result = (Object)['name'=>'','id'=>0,'no_price_mod'=>0];

  if(!logged_in())
    return $default_result;

  global $user_category;
  if($user_category)
    return $user_category;

	$status = lako::get('objects')->get('users')->read(array(
    'select'  => array('customer_category.^*'),
    'where'   => array('id',user_id())
		));
  $user_category = $status[0]['customer_category'];
  if(!isset($user_category['name'])){
    $user_category = false;
    return $default_result;
  }
  $user_category = (object)$user_category;
  return $user_category;
}


function user_id(){
	$ci=get_instance();
  return $ci->tank_auth->get_user_id();
}

function logged_in(){
  $ci = get_instance();
  return $ci->tank_auth->is_logged_in();
}

function auth_force(){
  if(!logged_in())
    redirect('auth/login');
}

function admin_force(){
  if(!is_role('admin'))
    redirect('auth/login');
}
