<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Booking extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  //$empid coming from search page
  public function index($empid=null){

    if(!empty($_POST)){
      $data = $_POST;
      $originalDate = $data['date'];
      $data['date'] = date("Y-m-d", strtotime($originalDate));
      if($this->bookingExists($data)){
        lako::get('flash')->set('global',array(
          'type'  => 'danger',
          'msg'   => 'This employee is already booked for this time peroid.'
        ));
      
        redirect('booking/index/'.$data['employee_id']);
      }

      Models\Booking::create($data);
      lako::get('flash')->set('global',array(
        'type'  => 'success',
        'msg'   => 'Booking Saved Successfully.'
      ));

      redirect('booking/index/'.$data['employee_id']);
    }

    $timeSlots = Models\TimeSlots::get();
    $this->load->view('booking', array(
    		'tslots' => $timeSlots,
    		'empid' => $empid,
    	));    
	}

  function bookingExists($data){
  
    $booking = Models\Booking::where('employee_id',$data['employee_id'])
                    ->where('date',$data['date'])
                    ->where('time_slot',$data['time_slot'])->first();
                   
                  
    if($booking)                
      return true;

    return false;
  }

  
}