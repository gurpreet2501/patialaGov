<?php 
use App\Models;
function getOtp(){
	$string = '0123456789';
  return substr(str_shuffle($string), 1, 6);
}


