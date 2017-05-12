<?php 
use App\Models;
function getOtp(){
	$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($string), 1, 7);
}


