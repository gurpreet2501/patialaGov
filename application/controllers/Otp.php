<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Otp extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function verify($user_id){
		 
     if(isset($_POST['otp'])){
        $user = Models\Users::where('id', $user_id)->first();   
        if($_POST['otp'] == $user->otp)
          {

            $user->update([
              'verified' => 1,
              ]);  

            lako::get('flash')->set('global',array(
                'type'  => 'success',
                'msg'   => 'Verification completed'
            ));

            redirect('auth/login');

          }else{
            lako::get('flash')->set('global',array(
                'type'  => 'danger',
                'msg'   => 'Verification Failed'
            ));

            redirect('otp/verify/'.$user_id);
          }
        
     }

     $this->sendOtp($user_id);

     $this->load->view('otp-verify', ['user_id' => $user_id]);    
	}

  public function resend($user_id){
      $otp = getOtp();
      Models\Users::where('id',$user_id)->update(['otp' => $otp]);
      lako::get('flash')->set('global', array(
                'type'  => 'success',
                'msg'   => 'New Otp Sent Successfully'
      ));

      redirect('otp/verify/'.$user_id);
  } 


  function sendOtp($user_id){

    $data = Models\Users::select('phone_number','otp')->where('id', $user_id)->first();
    $phone = $data->phone_number;
    $otp = $data->otp;
    $phone = preg_replace('/[^0-9]/', '', $phone);
    $phone = '91'.substr($phone, -10);
    
    if($this->config->item('site_status') == 'LIVE')
      $url = "http://sms.thinkbuyget.com/api.php?username=Gurpreet&password=472186&sender=DGENIT&sendto={$phone}&message=Please+enter+your+OTP++{$otp}+to+complete+your+registration.";
    else
      $url = '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec ($ch);
    curl_close ($ch);
    return true;
  }

  
}