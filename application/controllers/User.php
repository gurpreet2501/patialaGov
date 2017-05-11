<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Models as M;
use App\Libs\RestPaginator;
use Illuminate\Pagination\Paginator;

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
    $this->load->library('grocery_CRUD');
    auth_force();
    if(!is_role('user'))
      redirect('auth/logout');
	}

 	public function index($lang=false){
    redirect('user/bookings');
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

  function bookings(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking');
    $crud->set_subject('Bookings');
    $crud->set_relation('time_slot','time_slots','name');
    $crud->where('user_id', user_id());
    if($crud->getState() == 'edit')
      $crud->fields('booking_status');
    $crud->unset_add();
    $crud->unset_edit();
    $crud->unset_view();
    $crud->unset_export();
    $crud->unset_print();
    $crud->unset_delete();

    $crud->columns('name','email','date','time_slot','booking_status');
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
  }


  public function update_password(){
    $crud = new grocery_CRUD();
    if(($crud->getState() == 'read') || ($crud->getState() == 'list'))
      redirect("user/update_password/edit/".user_id());

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

