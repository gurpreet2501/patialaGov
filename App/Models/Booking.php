<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model{

  protected $fillable = ['name','email','age','sex','meeting_purpose','phone_no','date','employee_id','time_slot','booking_status','subject','user_id'];
  protected $table  = 'booking';

}
