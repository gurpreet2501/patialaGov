<?php
use App\Models as M;
function get_countries(){
  
  $countries = lako::get('objects')->get('countries')->read(array(
    'select'   =>  array('id','country')
  ));

  return $countries;
}


function get_states(){
  
  $states = lako::get('objects')->get('states')->read(array(
    'select'   =>  array('id','state_name')
  ));

  return $states;
}


function get_districts(){
  
  $districts = lako::get('objects')->get('district')->read(array(
    'select'   =>  array('id','district_name')
  ));
 
 return $districts;
  
}

function get_district_name($id){
  $district = M\District::select('district_name')->where('id',$id)->first();

  return (!empty($district)) ? $district->district_name : 'Null';

}