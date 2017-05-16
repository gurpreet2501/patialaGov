<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Models as M;
use App\Libs\RestPaginator;
use Illuminate\Pagination\Paginator;

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
    $this->load->library('grocery_CRUD');
    auth_force();
    if(!is_role('admin'))
      redirect('auth/logout');
	}

 	public function index($lang=false){
    redirect('admin/bookings');
  }

  public function bookingsCount($lang=false){
    $emp = [];
    $emp = M\Users::select('id','full_name','email','phone_number','designation','block','room_no','department')->where('role','employee')->get();
    if(!empty($emp)){
      $emp = $emp->toArray();
      
      foreach ($emp as $key => $val) {
       
        $bookings = M\Booking::where('employee_id', $val['id'])->where('date', date('Y-m-d'))->where('booking_status','Accepted')->count();
        $totalbookings = M\Booking::where('employee_id', $val['id'])->where('date', date('Y-m-d'))->count();
        $canceled = M\Booking::where('employee_id', $val['id'])->where('date', date('Y-m-d'))->where('booking_status','Canceled')->count();
        $pending = M\Booking::where('employee_id', $val['id'])->where('date', date('Y-m-d'))->where('booking_status','Pending')->count();

        $emp[$key]['accepted'] = $bookings;
        $emp[$key]['totalBookings'] = $totalbookings;
        $emp[$key]['canceled'] = $canceled;
        $emp[$key]['pending'] = $pending;
      }
    }
    
    $this->load->view('admin/bookingsCount', ['bookings' => $emp]);
	}

  public function timeSlots($lang=false){

    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('time_slots');
    $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
    $crud->field_type('updated_at','hidden');
    $crud->columns('name');
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }

 function feedbacks(){
    $feedbacks = M\Feedbacks::with('booking')->with('employee')->get();
    $this->load->view('feedbacks/admin-feedbacks',['feedbacks' => $feedbacks]);
  }
  function feedbackDetails($id){
    $feedbacks = M\Feedbacks::where('id',$id)->with('booking')->with('employee')->get();
    $this->load->view('feedbacks/admin-feedback-details',['feedbacks' => $feedbacks]);
  }

  public function users(){

		  if(user_role()!='admin'){
      	redirect('admin');
      }
      $crud = new grocery_CRUD();
      $crud->unset_export();
      $crud->unset_print();
      $crud->set_theme('datatables');
      $crud->set_table('users');
      $crud->set_subject('Employees');
      $crud->set_field_upload('profile_pic','images');
      $crud->columns('username','email','profile_pic','department','block','room_no');
      $crud->field_type('password', 'password');
      $crud->field_type('role', 'hidden','employee');
      $crud->field_type('verified', 'hidden',1);
      $crud->field_type('otp', 'hidden');
      $crud->required_fields('username','password','email','full_name');
      if($crud->getState() == 'add')
        $crud->unique_fields('username','email');
      $crud->unset_read();
      $crud->unset_delete();
      $crud->where('role','plant_manager');
      $crud->or_where('role','employee');
      $crud->unset_fields(
        'added_by',
        'district',
        'customer_type',
        'address_line_1',
        'address_line_2',
        'ban_reason',
        'new_password_key',
        'new_password_requested',
        'new_email_key',
        'last_ip',
        'last_login',
        'created',
        'activated',
        'banned',
        'new_email',
        'modified',
        'target_per_month'
      );

    $crud->callback_edit_field('password', array($this,'edit_field_callback'));
    $crud->callback_field('room_no', array($this,'field_room_no'));
    $crud->callback_field('block', array($this,'field_block_no'));
    $crud->callback_field('department', array($this,'department_field'));

    $crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
    $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
	}

  function field_room_no($value='', $pkey=0){
    
    $html = "<select id='field-role' name='room_no' class='chosen-select' data-placeholder='Select Room No'>";
    for($i=1; $i<=20; $i++){
      $selected = ($i == $value)? 'selected': '';
      $html .= "<option value='{$i}' {$selected}>{$i}</option>";
    }
    $html .= '</select>';
    return $html;
  }
  
  
  function field_block_no($value='', $pkey=0){
    $blocks = $this->config->item('blocks');
    $html = "<select id='field-role' name='block' class='chosen-select' data-placeholder='Select Room No'>";
    foreach($blocks as $block){
      $selected = ($block == $value)? 'selected': '';
      $html .= "<option value='{$block}' {$selected}>Block {$block}</option>";
    }
    $html .= '</select>';
    return $html;
  }

 function department_field($value='', $pkey=0){
   
    $departments = $this->config->item('departments');

    $html = "<select id='field-role' name='department' class='chosen-select' data-placeholder='Select Room No'>";
    foreach($departments as $dep){
      $selected = ($dep == $value)? 'selected': '';
      $html .= "<option value='{$dep}' {$selected}>{$dep}</option>";
    }
    $html .= '</select>';
    return $html;
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
		return '<input type="password" class="form-control" value="__PATIALAGOV__" name="password" style="width:462px">';
	}

  // function employeeBookings(){
  //   $crud = new grocery_CRUD();
  //   $crud->set_theme('datatables');
  //   $crud->set_table('booking');
  //   $crud->set_subject('Bookings');
  //   $crud->set_relation('time_slot','time_slots','name');
  //   $crud->where('employee_id',user_id());
  //   if($crud->getState() == 'edit')
  //     $crud->fields('booking_status');
  //   $crud->unset_add();
  //   $crud->unset_delete();
   
  //   $crud->columns('name','email','date','time_slot','booking_status','profile_pic');
  //   $output = $crud->render();
  //   $this->load->view('admin/crud.php',$output);
  // }

  function bookings(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking');
    $crud->unset_export();
    $crud->unset_print();
    $crud->set_subject('Bookings');
    $crud->set_relation('time_slot','time_slots','name');
    if($crud->getState() == 'edit')
      $crud->fields('booking_status');
    $crud->unset_add();
    $crud->display_as('employee_id','Employee Details');
    $crud->columns('name','email','date','time_slot','booking_status','subject','meeting_purpose','employee_id');
    $crud->callback_column('employee_id',array($this,'get_employee_details'));
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }

   function queries(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('queries');
    $crud->set_subject('Queries');
    $crud->unset_add();
    $crud->unset_texteditor(['question','answer']);
    $crud->field_type('user_id','hidden');
    $crud->field_type('question','readonly');
    $crud->field_type('created_at','hidden');
    $crud->field_type('updated_at','hidden');
    $crud->field_type('employee_id','hidden');
    $crud->display_as('user_id','User Details');
    $crud->callback_column('user_id',array($this,'get_user_details'));
    $crud->callback_column('employee_id',array($this,'get_employee_details'));
    $crud->columns('question','answer','user_id','employee_id');
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

  function get_employee_details($value, $row){
    $data= M\Users::select('full_name','email','phone_number','profile_pic','sex','designation')->where('id',$value)->first();
    $string =  $data->full_name.",<br/>";
    $string .= $data->email.",<br/>";
    $string .= $data->phone_number.",<br/>";
    $string .= $data->designation.".<br/>";
    return $string;
  }

  function acceptedBookings(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking');
    $crud->unset_export();
    $crud->unset_print();
    $crud->where('booking_status','Accepted');
    $crud->set_subject('Bookings');
    $crud->set_relation('time_slot','time_slots','name');
    if($crud->getState() == 'edit')
      $crud->fields('booking_status');
    $crud->unset_add();
    $crud->columns('name','email','date','time_slot','booking_status');
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }


  public function update_password(){
    $crud = new grocery_CRUD();
    if(($crud->getState() == 'read') || ($crud->getState() == 'list'))
      redirect("admin/update_password/edit/".user_id());

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

