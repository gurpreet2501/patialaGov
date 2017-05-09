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

        $results = $query->get();		
      } //if bracket closed

    $this->load->view('employee-search', ['results' => $results]);    
	}

  
}