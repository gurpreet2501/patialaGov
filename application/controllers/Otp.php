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
    $data = Models\Users::select('phone_number','otp')->where('id',$user_id)->first();
    $number = $data->phone_number;
    $otp = $data->otp;
    // http://sms.thinkbuyget.com/api.php?username=Gurpreet&password=472186&sender=DGENIT&sendto=919814158141&message=854785  

  }

  
}