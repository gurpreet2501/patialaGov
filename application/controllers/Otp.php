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
              'otp' => ''
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

     $this->load->view('otp-verify', ['user_id' => $user_id]);    
	}

  public function resend($user_id){
      $otp = getOtp();
      Models\Users::where('id',$user_id)->update(['otp' => $otp]);
      lako::get('flash')->set('global',array(
                'type'  => 'success',
                'msg'   => 'New Otp Sent Successfully'
      ));
      
      redirect('otp/verify/'.$user_id);
  } 


  
}