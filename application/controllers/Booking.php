<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Booking extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
    auth_force();
    if(!is_role('user'))
      redirect('auth/logout');
  }
  //$empid coming from search page
  public function index($empid=null){

    if(!empty($_POST)){
      $data = $_POST;
      $user = Models\Users::where('id',user_id())->first();
      $data['name'] = $user->full_name;
      $data['email'] = $user->email;
      $data['age'] = $user->age;
      $data['sex'] = $user->sex;
      $data['phone_number'] = $user->phone_number;
      $data['user_id'] = user_id();
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
      sendEmail($data);
      lako::get('flash')->set('global',array(
        'type'  => 'success',
        'msg'   => 'Booking Saved Successfully.'
      ));

      redirect('booking/index/'.$data['employee_id']);
    }

    $timeSlots = Models\TimeSlots::orderBy('id','ASC')->get();
    $bookings = Models\Booking::select('time_slot')->where('employee_id', $empid)->where('date',date('Y-m-d'))->get();
    $bookedSlots = array_column($bookings->toArray(), 'time_slot');
   
    $timeSlots = $timeSlots->toArray();
    foreach($timeSlots as $key => $tslot){
     
      if(in_array($tslot['id'],$bookedSlots))
        $timeSlots[$key]['disabled'] = true;
      else
        $timeSlots[$key]['disabled'] = false;
    }  
    

    $this->load->view('booking', array(
    		'tslots' => $timeSlots,
    		'empid' => $empid,
    	));    
	}

  function bookingExists($data){
  
    $booking = Models\Booking::where('employee_id',$data['employee_id'])
                    ->where('date', $data['date'])
                    ->where('time_slot', $data['time_slot'])->first();
                   
    if($booking)                
      return true;

    return false;
  }

  function checkBookings(){
     $bookings = [];
     $bookings = Models\Booking::where('user_id', user_id())->get(); 
     if(!empty($bookings)){
      $bookings = $bookings->toArray();
      foreach ($bookings as $key => $book) {
        $bookings[$key]['employee_details'] = Models\Users::where('id', $book['employee_id'])->first()->toArray();
        $tslot = Models\TimeSlots::select('name')->where('id', $book['time_slot'])->first()->toArray();
        $bookings[$key]['time_slot'] = $tslot['name'];

      }
     }

     $this->load->view('checkBookings',['bookings' => $bookings]);
  }

  
}