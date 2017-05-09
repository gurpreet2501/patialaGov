<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Search extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
		 $results = [];  	 

  	 if(isset($_POST['emp_name'])){

      $query = Models\Users::where('full_name','like',"%{$_POST['emp_name']}%")->where('role','employee');
      
      if(!empty($_POST['department']))
         $query = $query->where('department', '=', $_POST['department']); 
       
         $results = $query->get();			
     	}						 

     
   
    $this->load->view('search', ['results' => $results]);    
	}

	public function processing(){
		
	}

  
}