<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Queries extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
    auth_force();
    if(!is_role('user'))
      redirect('auth/logout');

  }
  
  public function submit(){
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

    $this->load->view('queries/employee-search-for-query', ['results' => $results]);    
	}

  public function showForm($emp_id){
    
    if(isset($_POST['question'])){
      Models\Queries::create($_POST);
      lako::get('flash')->set('global',array(
        'type'  => 'success',
        'msg'   => 'Query Submitted Successfully.'
      ));
      
      redirect('queries/showForm/'.$emp_id);  

    }

    $this->load->view('queries/queries-form',['emp_id' => $emp_id]);
  }
	public function show(){
     $queries = Models\Queries::where('user_id', user_id())->get(); 
     $this->load->view('queries/show',['queries' => $queries]);
	}

  
}