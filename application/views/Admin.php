<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
    $this->load->library('grocery_CRUD');
    auth_force();
    
    if((user_role() != 'admin') && (user_role() != 'plant_manager'))
      redirect('/');
    
	}

 	public function index($lang=false){	 
    redirect('admin/reports');
	}
  
  public function order_details($order_id=0){
    $order = order_details($order_id);
    if(empty($order))
      show_404();
    lako::import('order_print');
    $this->load->view('admin/order_details',array(
      'p_order'   => new lako_order_print($order),
      'order'     => $order,
      'js_files'  => array(
                      base_url('assets/grocery_crud/js/jquery-1.11.1.min.js'),
                      base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'),
                      base_url('assets/js/init-fancybox.js')),
      'css_files' => array(base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'))
    ));
  }
  
  public function reports(){
    $this->load->helper('reports');
    $data = [];
  	if(isset($_GET['from'])){
      $start_date = date('Y-m-d H:i:s',strtotime($_GET['from']));
      $end_date   = date('Y-m-d H:i:s',strtotime($_GET['to']));
      
      $where = [['date','>=', $start_date], 'AND', ['date','<=', $end_date]];
      
      if(is_role('plant_manager')){
        $where[] = 'AND';
        $where[] = ['plant_id',user_id()];
      }
      if(isset($_GET['customer']) && intval($_GET['customer'])){
        $where[] = 'AND';
        $where[] = ['user_id',$_GET['customer']];
      }
      
      $data = lako::get('objects')->get('orders')->read(array(
             'select'   => array('^*','items.^*','user.district.district_name','items.product.categories.category_name','items.product.district_target.^*'),
             'where'    => $where
      ));
    }
    
    if(isset($_GET['customer']) && intval($_GET['customer'])){      
      $dist_targets = obj('customer_targets')->read([
        'select'  => ['^*','customer.district.^*','category.category_name'],
        'where'   => ['customer_id',$_GET['customer']]
      ]);
      make_customer_target_report_friendly($dist_targets,$_GET['customer']);
    }else{
      $dist_targets = obj('district')->read([
        'select' => ['^*','district_target.^*','district_target.category.category_name']
      ]);
      if(is_role('plant_manager'))
        keep_plant_targets($dist_targets,user_id());
    }   
 
    //build report
    $cats = get_cats_from_targets($dist_targets);
    
    $report = [];
    
    foreach($dist_targets as $dist_target){
      $report[$dist_target['id']] = [
        'district_name' => $dist_target['district_name'],
        'categories'    => fill_report_categories($dist_target, $cats ,$data)
      ];
    }
    
    if(isset($_GET['download']) && !empty($data)){
      $name =  'Sales-Report-';
      $name .=  current(explode(' ',$start_date));
      $name .=  '-to-';
      $name .=  current(explode(' ',$end_date));
      $name .=  '.csv';
      
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename='.$name);
      $output = fopen('php://output', 'w');
      
      $head1 = $head2 = [''];
      foreach($cats as $cat){
        $head1[] = '';
        $head1[] = $cat['category_name'];
        $head1[] = '';
        
        $head2[] = 'Target';
        $head2[] = 'Sales';
        $head2[] = '%';
      }
      fputcsv($output, $head1);
      fputcsv($output, $head2);
      
      foreach($report as $row){
        $csv_row = [$row['district_name']];
        foreach($row['categories'] as $category)
          foreach($category as $num)
            $csv_row[] = $num;
            
        fputcsv($output, $csv_row);
      }
      exit;
    }    
  
    $this->load->view('admin/reports',array(      
      'show_customer_selection'=>  is_role('plant_manager'),
      'customers' =>  is_role('plant_manager')
                        ?obj('users')->read([
                          'select'  => ['id','full_name'],
                          'where'   => [['added_by',user_id()],'AND',['activated',1]],
                          'order_by'=> 'full_name'
                        ])
                        :[],
      'orders'    =>  $data,
      'cats'      =>  $cats,
      'report'    =>  $report,
      'css_files' =>  [base_url('assets/jquery-ui/jquery-ui.min.css')],
      'js_files'  =>  [ base_url('assets/jquery-ui/jquery-ui.min.js'),
                        base_url('assets/js/jq-ui-date.js') ],
    ));
  }
  
  public function order_print_details($order_id=0){
    $order = order_details($order_id);
    if(empty($order))
      show_404();
    
    $this->load->view('admin/order_print_details',array(
      'order'=>$order,
      'js_files' => array(
                      base_url('assets/grocery_crud/js/jquery-1.11.1.min.js'),
                      base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'),
                      base_url('assets/js/init-fancybox.js')),
      'css_files' => array(base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'))
    ));
  }
  
  public function store_settings(){
    $crud = new grocery_CRUD();
    if($crud->getState() == 'list'){
      $settings = obj('store_settings')->read(['select'=>['id','plant_id'],'where'=>['plant_id',user_id()]]);
      if(empty($settings)){
        $insert = obj('store_settings')->insert(['plant_id'=>user_id()]);
        if(!isset($insert['store_settings']))
          show_404();
        redirect("admin/store_settings/edit/{$insert['store_settings']}");
      }
      redirect("admin/store_settings/edit/{$settings[0]['id']}");
    }
    
    $crud->set_theme('datatables');
    $crud->set_table('store_settings');
    $crud->unset_edit_fields('plant_id');
    $crud->display_as('booking_duration','Booking Expires in Days');
    $crud->set_subject('Settings');
    $crud->display_as('allow_bookings','Allow Advanced Bookings');
    
    $output = $crud->render();
    
    if($crud->getState() == 'edit')
      $output->css_files[] = base_url('assets/css/edit-only-window.css');
    
    $this->load->view('admin/crud.php',$output);
  }
  
  public function orders(){
    $filters = (isset($_GET['filters']) && is_array($_GET['filters']))? $_GET['filters']: [];
    $filters = array_merge([
      'page'      => 1,
      'per_page'  => 20,
      'order'     => 'latest',
      'status'    => 'Pending',
    ],$filters);
    
    $filters['page']      = intval($filters['page']);
    $filters['per_page']  = intval($filters['per_page']);
    
    $where = [['^1','1']];
    if(is_role('plant_manager')){
      $where[] = 'AND';
      $where[] = ['plant_id',user_id()];
    }
      
    if($filters['status'] != '0'){
      $where[] = 'AND';
      $where[] = ['status',$filters['status']];
    }
    
    if($filters['order'] == 'oldest')
      $order_by = ['date','ASC'];
    else
      $order_by = ['date','DESC'];
    
    
    $orders = obj('orders')->read([
      'select'  => ['id','status','date','customer.full_name','customer.district','payment_details.verified'],
      'where'   => $where,
      'pagination' => [
        'page'      => $filters['page'],
        'per_page'  => $filters['per_page']
      ],
      'order_by'  => $order_by
    ]);
    $this->load->view('admin/orders',[
      'orders'    => $orders,
      'filters'   => $filters
    ]);
  }

  public function update_order(){
    $crud = new grocery_CRUD();
    $crud->set_table('orders');
    $crud->set_subject('Order');
    $crud->edit_fields('status');
    $output = $crud->render();
    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/frame-crud.php',$output);
  }
  
  public function payment_details(){
    $crud = new grocery_CRUD();
    $crud->edit_fields('receipt','verified');
    $crud->display_as('verified','Verification Status');
    $crud->field_type('verified','dropdown',['0'=>'Not Verified','1'=>'Verified']);
    
    $crud->unset_texteditor(true);
    $crud->set_theme('datatables');
    $crud->set_table('payment_details');
    $crud->set_subject('Payment Details');
    $crud->unset_export();
    $crud->unset_print();
    $output = $crud->render();
    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/frame-crud.php',$output);
  }
  
  public function price_adjust(){
    $crud = new grocery_CRUD();
    $crud->unset_texteditor(true);
    $crud->set_theme('datatables');
    $crud->set_table('price_adjust');
    $crud->set_subject('Adjust Price');
    $crud->unset_export();
    $crud->unset_print();
    $output = $crud->render();
    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/frame-crud.php',$output);
  }

	public function shipment_export(){   
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('shipment_export');
    $check_fields = array('stock_ready_for_inspection',
                          'expected_inspection',
                          'inspection_completed',
                          'documents_filed',
                          'documents_cleared',
                          'handed_over_to_transporter',
                          'custom_clearence_received',
                          'moved_from_dry_port',
                          'loaded_in_ship');
    
    
    foreach($check_fields as $check_field)
      $crud->callback_field($check_field,array($this,'field_shipment_status'));
    
    $crud->unset_fields('order_id');
    
    $crud->set_subject('Shipment Export');
    $output = $crud->render();
    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/frame-crud',$output);
	}

	public function shipment_domestic(){   
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('shipment_domestic');
    $check_fields = array('handed_over_to_transporter');
    
    
    foreach($check_fields as $check_field)
      $crud->callback_field($check_field,array($this,'field_shipment_status'));
  
    $crud->unset_fields('order_id');
    $crud->set_subject('Shipment Domestic');
    $output = $crud->render();
    $output->css_files[] = base_url('assets/css/edit-only-window.css');
    $this->load->view('admin/frame-crud',$output);
	}

  public function district_target(){   
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('district_target');
    $crud->set_subject('District Target');
    
    $crud->where('user_id',user_id());
    $crud->fields('weight_unit','target','category','district_id','user_id');
    $crud->columns('target','weight_unit','category','district_id');
    $crud->required_fields('target','weight_unit','category','district_id');
    
    $crud->display_as('district_id','District');
    $crud->set_relation('district_id','district','district_name');
    $crud->set_relation('category','categories','category_name',['added_by'=>user_id()]);
    
    
    
    
    $crud->change_field_type('user_id', 'hidden', user_id());
    Crud_helper::disable_pev($crud);
    
    $output = $crud->render();
    $fancy_box_init_js = base_url('assets/js/init-fancybox.js');
    $output->js_files[md5($fancy_box_init_js)] = $fancy_box_init_js;
    
    
    $this->load->view('admin/crud',$output);
	}
  
  public function customer_target(){   
    $this->load->view('admin/customer_target');
	}
  
  function field_shipment_status($value='', $pkey=0, $field_info){
   
    $html = "<select id='field-{$field_info->name}' name='{$field_info->name}' class='chosen-select' data-placeholder='Select Status'>";
    foreach(array('0','1') as $option){
      $selected = ($option == $value)? 'selected': '';
      $option_name = strip_tags(stage_value($option));
      $html .= "<option value='{$option}' {$selected} >{$option_name}</option>";
    }
    $html .= '</select>';
    return $html;
  }

	public function products(){
    $crud = new grocery_CRUD();
    if($crud->getState() == 'add')
      $this->create_product_draft_and_edit();
    
    $crud->set_theme('datatables');
    $crud->unset_print();
    $crud->unset_export();
    $crud->unset_read();
    $crud->set_table('products');
    $crud->set_subject('Products');
    $crud->columns('product_name','category','status');
    $crud->edit_fields('sku','product_name','price',
                        'stock','description','category','image',
                        'weight_unit','weight','status','discount','tax');
                        
    $crud->display_as('sku','SKU');
    
    $crud->callback_field('discount','Crud_helper::product_discount_field');
    
    $crud->set_lang_string('delete_error_message',
    'This product is booked by a customer, it cannot be deleted. You can update its status to draft to hide it from public.');
    
    $crud->callback_field('tax','Crud_helper::product_tax_field');
    
    $crud->required_fields('product_name','price');
    $crud->field_type('plant_id', 'hidden',user_id());
    
    $crud->where('plant_id',$this->tank_auth->get_user_id());
    $crud->set_relation('category','categories','category_name');
    $crud->set_field_upload('image','assets/uploads/files');    
    $crud->callback_field('category', array($this,'field_product_category'));
    $crud->callback_delete('Crud_helper::delete_product');
    $output = $crud->render();
    $fancy_box_init_js = base_url('assets/js/init-fancybox.js');
    $output->js_files[md5($fancy_box_init_js)] = $fancy_box_init_js;
    $this->load->view('admin/crud',$output);
	}
  
  function product_name_field($value = '', $primary_key = null){
    return '<input type="text" maxlength="500" value="'.htmlspecialchars($value).'" name="product_name" class="form-control" id="field-product_name">';
  }
  
  function field_product_category($value='', $pkey=0){
    $html = "<select id='field-category' name='category' class='chosen-select' data-placeholder='Select Category'>";
    $cats = obj('categories')->read(array(
              'select'  => array(),
              'where'   => array('added_by',user_id())
            ));
    foreach($cats as $cat){
      $selected = ($cat['id'] == $value)? 'selected': '';
      $category_name = htmlentities($cat['category_name']);
      $html .= "<option value='{$cat['id']}' {$selected} >{$category_name}</option>";
    }
    $html .= '</select>';
    return $html;
  }
  
  private function create_product_draft_and_edit(){
    $product = lako::get('objects')->get('products')
                    ->insert(array(
                      'plant_id'  => $this->tank_auth->get_user_id(),
                      'status'    => 'Draft'));
    redirect("admin/products/edit/{$product['products']}/");
    exit;
  }

	public function categories($lang=false){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('categories');
    $crud->set_subject('Categories');
    
    $crud->set_lang_string('alert_delete',
    'If any product or target is still associated to this category it cannot not be deleted. Please make sure no product or target uses this category.');
    $crud->set_lang_string('delete_error_message',
    'This category cannot be deleted please make sure no target or products uses this category.');
    $crud->callback_delete('Crud_helper::delete_category');
    
    
    $crud->where('added_by',user_id());
    $crud->columns('category_name');
    $crud->unset_print();
    $crud->unset_export();
    $crud->unset_read();
    $crud->field_type('added_by','hidden',user_id());
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
	}
  
  public function customers($order_id=0){
     
    $crud = new grocery_CRUD();
    $crud->set_table('users');
    $crud->set_subject('Customer');
    $crud->set_theme('datatables');
    
    //**  Handle Delete **//
    $crud->set_lang_string('delete_error_message',
    'This Customer cannot be deleted because it is associated to some bookings or orders. But You can ban him from using the site.');
    $crud->callback_delete('Crud_helper::delete_customer');
    
    
    $crud->set_rules('username','Username','min_length[3]|max_length[50]');
    $crud->field_type('added_by', 'hidden',user_id());
    $crud->field_type('role', 'hidden','customer');
    $crud->field_type('password', 'password');
    $crud->unique_fields('username','email');
    
    if(user_role() =='plant_manager')
      $crud->where('added_by', user_id());
    else
      $crud->where('added_by', 0);
    
    $crud->where('role', 'customer');
    
    $crud->display_as('customer_type', 'Shipping Type');    
    
    $crud->columns('full_name','username','email','district');
    $crud->set_relation('district','district','district_name');
    
    $crud->unset_add_fields('discounts','tax','targets');      
    
    $crud->add_fields('username','password','email','full_name','phone_number',
                     'address_line_1','address_line_2','city','state','zip_code',
                     'district','customer_type','banned','ban_reason','added_by'
                     ,'role');
                     
    $crud->edit_fields('username','password','email','full_name','phone_number',
                     'address_line_1','address_line_2','city','state','zip_code',
                     'customer_type','district','discounts','tax','targets'
                     ,'banned','ban_reason','added_by','role');
                     
    if($crud->getState() != 'add'){
      $crud->callback_field('discounts','Crud_helper::customer_discount_field');
      $crud->callback_field('tax','Crud_helper::customer_tax_field');
      $crud->callback_field('targets','Crud_helper::customer_targets_field');  
    }    
    
    //$crud ->required_fields('insert_success_message','target','weight_unit','category_id');
    $crud->required_fields('username','password','email','role','full_name','customer_type','banned','district');
    
    $crud->unique_fields('username','email');
    $crud->unset_texteditor(true);
    $crud->unset_export(true);
    $crud->unset_print(true);
    $crud->unset_read(true);
    $crud->unset_fields(
      //'ban_reason',
      'new_password_key',
      'new_password_requested',
      'new_email_key',
      'last_ip',
      'last_login',
      'created',
      'activated',
      //'banned',
      'new_email',
      'modified'
    );
      
    $crud->callback_edit_field('password', array($this,'edit_field_callback'));
    $crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
    $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
    $output = $crud->render();
    Crud_helper::install_full_fancybox($output);
    
    $this->load->view('admin/crud.php',$output);
  }
 	
  public function users(){ 
		  if(user_role()!='admin'){
      	redirect('admin');
      }
      $crud = new grocery_CRUD();
      $crud->set_theme('datatables');
      $crud->set_table('users');
      $crud->set_subject('Site User');
      $crud->columns('username','email','role');
      $crud->field_type('password', 'password');
      $crud->required_fields('username','password','email','role','full_name');
      $crud->unique_fields('username','email');
      $crud->unset_read();
      $crud->where('role','plant_manager');
      $crud->or_where('role','admin');
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
    $crud->callback_field('role', array($this,'field_role_admin'));
    
    $crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
    $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
    $output = $crud->render();
    $this->load->view('admin/crud.php',$output);
	}
  
  function field_role_admin($value='', $pkey=0){
    $html = "<select id='field-role' name='role' class='chosen-select' data-placeholder='Select Role'>";
    foreach(array('admin','plant_manager') as $role){
      $selected = ($role == $value)? 'selected': '';
      $html .= "<option value='{$role}' {$selected} >{$role}</option>";
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
		return '<input type="password" class="form-control" value="__MARKF3D__" name="password" style="width:462px">';
	}
  
  function bookings(){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking');
    $crud->set_subject('Bookings');
    
    $crud->columns('id','user_id','date');
    
    if(user_role() == 'plant_manager')
      $crud->where('plant_id',user_id());
    
    $crud->display_as('user_id','Customer'); 
   
    $crud->set_relation('user_id','users','full_name');
    $crud->edit_fields('date','products');
    $crud->callback_field('products',[$this,'field_booking_products']);
    
    $crud->add_action('Details', '', 'admin/booking_items','ui-icon-plus');
    
    if($crud->getState() != 'edit')
      $crud->unset_edit();
    
    $crud->unset_delete();
    $crud->unset_read();
    $crud->unset_add();
    $crud->unset_export();
    $crud->unset_print();
    
    $output = $crud->render();
    Crud_helper::install_full_fancybox($output);
    
    $this->load->view('admin/crud.php',$output);
  }
  
  public function field_booking_products($value='', $pkey=0){
    return  '<p>'.
              '<a href="'.site_url("admin/booking_items/{$pkey}").'" class="fancy iframe">See Booked Products</a>'.
            '</p>';
  }
  
  public function booking_items($booking_id){
    $crud = new grocery_CRUD();
    $crud->set_theme('datatables');
    $crud->set_table('booking_items');
    $crud->set_subject('Booked Products');
    $crud->set_relation('product_id','products','{product_name} ({weight} {weight_unit})');
    $crud->display_as('product_id','Product');
    $crud->columns('product_id','price','total_quantity','remaining_qty');
    $crud->edit_fields('total_quantity','price','remaining_stock');
    $crud->where('booking_id',$booking_id);
    
    $crud->unset_add();
    $crud->unset_read();
    $crud->unset_edit();
    $crud->unset_delete();
    $crud->unset_export();
    $crud->unset_export();
    $crud->unset_print();
    
    $output = $crud->render();    
    $this->load->view('admin/booking-crud.php',$output);
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