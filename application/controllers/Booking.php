<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
use Illuminate\Database\Capsule\Manager as DB;
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
      $user = Models\Users::where('id', user_id())->first();
      $data['name'] = $user->full_name;
      $data['email'] = $user->email;
      $data['age'] = $user->age;
      $data['sex'] = $user->sex;
      $data['phone_no'] = $user->phone_number;
      $data['user_id'] = user_id();
      $originalDate = $data['date'];
      $data['date'] = date("Y-m-d", strtotime($originalDate));

      if($data['date'] < date('Y-m-d')){
        lako::get('flash')->set('global',array(
          'type'  => 'danger',
          'msg'   => 'Please Enter Correct Date. Date Previous than today is not accepted.'
        ));
      
        redirect('booking/index/'.$data['employee_id']);  
      }
      
      $this->checkIfSameBookingLessThanTenDays($data);   

      if($this->bookingExists($data)){
        lako::get('flash')->set('global',array(
          'type'  => 'danger',
          'msg'   => 'This employee is already booked for this time period.'
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
    $bookings = Models\Booking::select('time_slot')->where('employee_id', $empid)->where('date', date('Y-m-d'))->get();
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
                    ->where('booking_status','!=' ,'Canceled')
                    ->where('time_slot', $data['time_slot'])->first();
              
    if($booking)                
      return true;

    return false;
  }

  function checkBookings(){
     $bookings = [];
     
     if(isset($_POST['booking_id'])){
      Models\Booking::where('id',$_POST['booking_id'])->update(['booking_status' => 'Canceled']);
     }

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

  function checkIfSameBookingLessThanTenDays($data){
    $new_timestamp = strtotime('-9 days', strtotime($data['date']));
    $previousDate =  date("Y-m-d",$new_timestamp);

    $query = "
      select * from booking 
      where user_id={$data['user_id']} 
      AND 
      employee_id={$data['employee_id']}
      AND 
      booking_status != 'Canceled'
      AND 
      date >= '{$previousDate}' AND date <= '{$data['date']}' 
      ";
 
    $results = DB::select($query);
    
    if(count($results)){
      lako::get('flash')->set('global',array(
          'type'  => 'danger',
          'msg'   => 'You can book the same employee after 10 days with respect to your previous booking.'
        ));         

      redirect('/employeeSearch');      
    }

  
  }
}