<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model{
  protected $fillable = ['feedback','user_id','booking_id'];
  protected $table  = 'feedbacks';

  public function booking()
    {
        return $this->hasOne('App\Models\Booking','id','booking_id');
    }

  public function employee()
    {
        return $this->hasOne('App\Models\Users','id','user_id');
    }

}
