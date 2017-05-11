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
  


  
  
 
  //******* general unset print export view *******//

}


