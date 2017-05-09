<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlots extends Model{
  protected $fillable = ['name'];
  protected $table    = 'time_slots';

}
