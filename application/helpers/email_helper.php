<?php 
use App\Models;
function sendEmail($data){
	$CI =& get_instance();
	
	$usr = Models\Users::select('email')->where('id',$data['employee_id'])->first();
	$tslot = Models\TimeSlots::select('name')->where('id',$data['time_slot'])->first();

	$mail = '';
	$mail.= 'Name: '.$data['name'].PHP_EOL;
	$mail.= 'Email: '.$data['email'].PHP_EOL;
	$mail.= 'Phone No: '.$data['phone_no'].PHP_EOL;
	$mail.= 'Age: '.$data['age'].PHP_EOL;
	$mail.= 'Sex: '.$data['sex'].PHP_EOL;
	$mail.= 'Age: '.$data['name'].PHP_EOL;
	$mail.= 'Time Slot: '.$tslot->name.PHP_EOL;
	$mail.= 'Date: '.$data['date'].PHP_EOL;
	$mail.= 'Meeting Purpose: '.$data['meeting_purpose'].PHP_EOL;

	if(mail($usr->email, "Booking Information",$mail))
		return true;

	return false;
}

