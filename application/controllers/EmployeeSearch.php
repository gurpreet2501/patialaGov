<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class EmployeeSearch extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
		 
     $results = [];  	 
     
  	 if(isset($_POST)){
        
        $data = $_POST;
        
        $query = Models\Users::where('role','employee');  
        
        if(!empty($data['room_no']))
          $query->where('room_no','=', $data['room_no']);
      
        if(!empty($data['block']))
          $query->where('block','=', $data['block']);

        if(!empty($data['department']))
          $query->where('department','=', $data['department']);

        if(!empty($data['name']))
          $query->where('full_name','like', "%{$data['name']}%");

        $results = $query->orderBy('full_name')->get();		
       
      } //if bracket closed

    $this->load->view('employee-search', ['results' => $results]);    
	}

  
}