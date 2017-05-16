<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queries extends Model{
  protected $fillable = ['question','answer','user_id','employee_id'];
  protected $table    = 'queries';

}
