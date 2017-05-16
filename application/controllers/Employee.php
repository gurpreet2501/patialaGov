<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Models as M;
use App\Libs\RestPaginator;
use Illuminate\Pagination\Paginator;

class Employee extends CI_Controller {

	public function __construct(){
		parent::__construct();
    $this->load->library('grocery_CRUD');
    auth_force();
    if(!is_role('employee'))
      redirect('auth/logout');
	}

 	public function index($lang=false){
    redirect('employee/bookings');
	}

 
  function on_update_encrypt_password_callback($post_array){
		if($post_array['password'] != '__MARKF3D__'){
      $password=$post_array['password'];
			$hasher = new PasswordHash(
	    		$this->config->item('phpass_hash_strength', 'tank_auth'),
		    	$this->config->item('phpass_hash_portable', 'tank_auth')
			);

			$post_array['password'] = $hasher->HashPassword($password);
			$post_array['activated'] = 1;
			return $post_array;
		}

		unset($post_array['password']);
		return $post_array;
	}

  function edit_field_callback($post_array){
		return '<input type="password" class="form-control" value="__MARKF3D__" name="password" style="width:462px">';
	}

  function bookings(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking');
    $crud->set_subject('Bookings');
    $crud->set_relation('time_slot','time_slots','name');
    $crud->where('employee_id',user_id());
    if($crud->getState() == 'edit')
    $crud->fields('booking_status');
    $crud->unset_add();
    $crud->unset_delete();
    $crud->columns('name','email','date','time_slot','booking_status');
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }

  function queries(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('queries');
    $crud->set_subject('Queries');
    $crud->where('employee_id',user_id());
    $crud->unset_add();
    $crud->unset_texteditor(['question','answer']);
    $crud->field_type('question','readonly');
    $crud->field_type('user_id','hidden');
    $crud->field_type('created_at','hidden');
    $crud->field_type('updated_at','hidden');
    $crud->field_type('employee_id','hidden');
    $crud->display_as('user_id','User Details');
    $crud->callback_column('user_id',array($this,'get_user_details'));
    $crud->unset_delete();
    $crud->columns('question','answer','user_id');
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }
   
  function get_user_details($value, $row){
    $data= M\Users::select('full_name','email','phone_number','profile_pic','sex','designation')->where('id',$value)->first();
    $string =  $data->full_name.",<br/>";
    $string .= $data->email.",<br/>";
    $string .= $data->phone_number.",<br/>";
    $string .= $data->designation.".<br/>";
    return $string;
  }
   function employeeBookings(){
    if(isset($_POST['booking_id'])){
        $data = $_POST; 
        M\Feedbacks::create($data);
        M\Booking::where('id',$data['booking_id'])->update(['feedback_sent' => true]);
        redirect('employee/employeeBookings');
    }

    $bookings = M\Booking::where('employee_id',user_id())->where('booking_status','Accepted')->where('feedback_sent',false)->get();
    $this->load->view('booking/employee-booking-list',['bookings' => $bookings]);
  }

  function bookingFeedbacks(){
    $feedbacks = M\Feedbacks::where('user_id', user_id())->with('booking')->get();
   
    $this->load->view('feedbacks/employee-feedbacks',['feedbacks' => $feedbacks]);
  }



  public function update_password(){
    $crud = new grocery_CRUD();
    if(($crud->getState() == 'read') || ($crud->getState() == 'list'))
      redirect("employee/update_password/edit/".user_id());

    $crud->set_theme('datatables');
    $crud->set_table('users');
    $crud->edit_fields('password');
    $crud->set_subject('Password');
    $crud->unset_export();
    $crud->unset_print();

    $crud->callback_edit_field('password', array($this,'edit_field_callback'));

    $crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
    $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));

    $output = $crud->render();

    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/order-crud.php',$output);
  }

}

