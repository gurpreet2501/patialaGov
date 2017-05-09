<?php
use App\Libs\SmsDummy;
use App\Libs\Sms;
use App\Models\Orders;

function sms($number,$msg){
	
  $envFile = require(__DIR__.'/../../environment.php');
	if($envFile['sms_sender'] == 'DUMMY')
		return SmsDummy::send($number, $msg);
	else
		return Sms::send($number, $msg);
}


function send_sms($number, $order_id){
	$status = Orders::find($order_id)->status;
	$msg = 'Order No '.$order_id.' '.$status.' .';
	return sms($number,$msg);
}
