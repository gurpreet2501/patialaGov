<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model{
  protected $fillable = ['country','verified','otp'];
  protected $table  = 'users';
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';


    public function plantsConfig()
    {
        return $this->hasMany('App\PlantsConfiguration');
    }



}
