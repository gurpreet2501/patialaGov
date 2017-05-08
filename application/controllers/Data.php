<?php defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Data extends MY_Controller
{
    public function index(){
      $this->view('Dashboard');
    }

    public function products()
    {
        $crud = $this->crud_init('products', ['name', 'price','stock']);
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $crud->display_as('price','Price (in Kg)(in Rs)');
        $crud->display_as('stock','Stock (in Kg)');
        $crud->required_fields('name','price','stock','active');
        $crud->set_field_upload('logo','assets/uploads/files');
        $this->view_crud($crud->render(), 'Add Potato Types');
    }

    public function records()
    {
        $crud = $this->crud_init('records', []);
        // $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('data','hidden','');
        $this->view_crud($crud->render(), 'Add Record');
    }

    public function reports()
    {
         

        $template = 'admin/report';

        $this->load->view('custom-crud',[
            'template' => $template
            ]);
    }

    public function potatoes()
    {
        $crud = $this->crud_init('potatoes', []);
        // $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('date','hidden', date('Y-m-d'));
        $this->view_crud($crud->render(), 'Add Potato Variety');
    }

    public function	seller_records()
    {
        $crud = $this->crud_init('seller_records', []);
        // $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        // $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Add Seller Records');
    }
 
    public function	buyer_records()
    {
        $crud = $this->crud_init('buyer_records', []);
        // $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        // $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Add Buyer Records');
    }

    public function	dispatches()
    {
        $crud = $this->crud_init('dispatch', []);
        $crud->set_relation('invoice','storage','invoice_no');
        $crud->set_lang_string('insert_error','You are trying to dispatch more than the available stock');
        $crud->field_type('date','hidden',date('Y-m-d H:i:s'));
        $crud->callback_before_insert(array($this,'checkIfStockSufficientToDispatch'));
        $this->view_crud($crud->render(), 'Add Dispatch');
    }

    function totalDispatch($dispatches){
      $data = [
        'ration' => 0,
        'seed' => 0,
        'goli' => 0,
        'no_12' => 0,
        'cut' => 0
      ];
      foreach ($dispatches as $key => $dispatch) {
        $data['ration'] = $data['ration'] + $dispatch->ration;
        $data['seed'] = $data['seed'] + $dispatch->seed;
        $data['goli'] = $data['goli'] + $dispatch->goli;
        $data['cut'] = $data['cut'] + $dispatch->cut;
        $data['no_12'] = $data['no_12'] + $dispatch->no_12;
        
      }
      return $data;
    }

    function calculateAvailableStock($storage,$dispatches){
      $stock = [];
      $keys = ['ration','goli','no_12','cut','seed'];
      foreach ($keys as $key => $val) {
        $stock[$val] = $storage[$val] - $dispatches[$val];
      }

     return $stock;
    }

    function checkIfStockSufficientToDispatch($post_array){
        $crud = $this->crud_init('dispatch', []);
        $storage = Models\Storage::select('ration','no_12','goli','cut','seed')->where('invoice_no',$post_array['invoice'])->first();
        $allDispatches = Models\Dispatch::select('ration','no_12','goli','cut','seed')->where('invoice',$post_array['invoice'])->get();

        $totalDispatch = $this->totalDispatch($allDispatches);
        $stockAvailable = $this->calculateAvailableStock($storage,$totalDispatch);
        $keys = ['ration','goli','no_12','cut','seed'];
        
        
        foreach ($keys as $key => $val) {
          if($post_array[$val] > $stockAvailable[$val])
            {
              return false;
            }
        }

        return true;

    }

    public function storage()
    {   
        //Potato type is potato variety
        $crud = $this->crud_init('storage', 
            ['date','invoice_no','owner','brand','logo','location','replacement','potato_type','ration','seed','goli','no_12','cut','bags']);
        $crud->fields('date','invoice_no','owner','brand','logo','location','replacement','potato_type','ration','seed','goli','no_12','cut','bags');
        $crud->set_relation('potato_type','potatoes','name');
        $crud->set_relation('brand','brands','brand_name');
        // $crud->set_relation('record_id','records',"Invoice No :{invoice_no}, Owner Name: {owner_name}, Phone: {phone}, Date: {date}");
        $crud->set_field_upload('logo','assets/uploads/files');
        $crud->callback_after_insert(array($this, 'updateInvoiceNo'));
        $crud->callback_after_update(array($this, 'updateInvoiceNo'));
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->display_as('potato_type','Potato Variety');
        $crud->display_as('ration','R-Ration');
        $crud->display_as('seed','S-Seed');
        $crud->display_as('goli','G-Goli');
        $crud->display_as('bags','Total');
        $crud->display_as('cut','C-Cut');
        $crud->field_type('updated_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('invoice_no','hidden');
        $this->view_crud($crud->render(), 'Add Storage Details');
    }

    function updateInvoiceNo($post_array,$primary_key){
        
        Models\Storage::where('id',$primary_key)->update(['invoice_no' => $primary_key]);
        return true;
    }

    public function countries()
    {
        $crud = $this->crud_init('countries', ['name']);
        $crud->unique_fields(array('name'));
        $crud->required_fields('name');
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Add Countries');
    }

    public function states()
    {
        $crud = $this->crud_init('states', ['name']);
        $crud->unique_fields(array('name'));
        $crud->required_fields('name');
        $crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Add States');
    }

    public function cities()
    {
        $crud = $this->crud_init('cities', ['name']);
        $crud->unique_fields(array('name'));
        $crud->required_fields('name');
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Add Cities');
    }

    public function dispatch_items()
    {
        $crud = $this->crud_init('dispatch', []);
        $crud->required_fields('stock','customer_id','product_id','tax','dispatched_on','driver_name','contact');
        $crud->display_as('customer_id','Select Customer');
        $crud->display_as('product_id','Select Product');
        $crud->set_relation('customer_id','customers','name');
        $crud->set_relation('product_id','products','name');
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $this->view_crud($crud->render(), 'Create New Dispatch');
    }

    public function customers()
    {
        $crud = $this->crud_init('customers', ['name', 'address','phone']);
        $crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('updated_at','hidden');
        $crud->set_relation('city','cities','name');
        $crud->set_relation('state','states','name');
        $crud->set_relation('country','countries','name');
        $crud->required_fields('name','phone','address','city','state','country');
        $crud->set_field_upload('logo','assets/uploads/files');
        $this->view_crud($crud->render(), 'Add Potato Types');
    }

  public function brands()
    {
        $crud = $this->crud_init('brands', ['brand_name']);
        $crud->unset_delete();
        $crud->field_type('created_at','hidden');
        $crud->field_type('updated_at','hidden');
        $crud->unique_fields('brand_name');
        // $crud->unset_add();
        $crud->unset_edit();
        $this->view_crud($crud->render(), 'Brands');
    }


    /**
     * @users Method
     */
    public function users()
    {
        switch ($this->uri->segment(3, '')){

        default:
            $this->admin();
        break;
        }
    }
    /**
     * @Jobs Method
     */
    public function jobs()
    {
        switch ($this->uri->segment(3, '')){
        default:
            $this->admin();
        break;
        }
    }



    private function admin()
    {

        $crud = $this->crud_init('tank_auth_users', ['username', 'email','banned']);
        $crud->fields(['email','username','password','activated', 'banned']);
        $crud->field_type('activated', 'hidden',1);
        $crud->field_type('banned', 'hidden',0);
        $crud->field_type('banned', 'true_false', array('No', 'Yes'));
        $crud->unset_read();

        $this->set_password_field($crud, 'tank_auth_password_callback');

        if ($this->is_insert_req()){
            $this->set_rules($crud, 'create_admin');
        }

        $this->view_crud($crud->render(), 'Admin User');
    }

    public function appliance_type()
    {
        $crud = $this->crud_init('appliance_types',[
            'name','service_id','has_power_source','for_consumer'
        ]);

        $crud->where('_soft_deleted',0);
        $crud->field_type('_soft_deleted','hidden');
        $crud->set_field_upload('image', '../images');
        $crud->set_relation('service_id','services', 'name');
        $this->set_bool($crud, ['has_power_source']);
        $crud->set_relation_n_n('repair_type', 'appliance_types_repair_types', 'repair_types', 'appliance_id', 'repair_id', 'name');
        $crud->set_relation_n_n('install_types', 'appliance_types_install_types', 'install_types', 'appliance_id', 'installtype_id', 'name');
        $crud->callback_delete(array($this,'_soft_deleted_the_appliance_type'));
        $crud->display_as([
            'has_power_source' => 'Power Source',
            'service_id'       => 'Service',
            'name'             => 'Type',
        ]);


        $this->view_crud($crud->render(), 'Appliance Types');
    }

    public function appliance_types_variations()
    {
        $crud = $this->crud_init('appliance_types_variations',['name','appliance_type_id']);

        $crud->display_as('appliance_type_id','Appliance');

        $crud->set_relation('appliance_type_id','appliance_types','name');

        $crud->field_type('created_at', 'hidden');

        $crud->field_type('updated_at', 'hidden');

        $this->view_crud($crud->render(), 'Appliance Types Variations');
    }

    public function _soft_deleted_the_appliance_type($primary_key)
    {
      $this->db->where('id', $primary_key);
      $this->db->update('appliance_types',array('_soft_deleted' => 1));
      return true;
    }

    public function repair_types()
    {
        $crud = $this->crud_init('repair_types',['name','cost']);

        $crud->where('_soft_deleted',0);

        $crud->field_type('created_at', 'hidden');

        $crud->field_type('updated_at', 'hidden');

        $crud->field_type('_soft_deleted','hidden');
        $crud->callback_delete(array($this,'_soft_deleted_repair_types'));

        if($crud->getState()=='add')
            $crud->required_fields('name','cost');

        if($crud->getState()=='edit')
            $crud->field_type('cost','readonly');


        $this->view_crud($crud->render(), 'Repair Types');
    }

    public function install_types()
    {
        $crud = $this->crud_init('install_types',['name','cost']);

        $crud->field_type('created_at', 'hidden');

        $crud->field_type('updated_at', 'hidden');

        if($crud->getState()=='add')
            $crud->required_fields('name','cost');

        if($crud->getState()=='edit')
            $crud->field_type('cost','readonly');

        $this->view_crud($crud->render(), 'Install Types');
    }

    public function warranty_plans_appliance_types(){
      $crud = $this->crud_init('warranty_plans_appliance_types', ['warranty_plan_id','appliance_type_id','appliance_type_variation_id']);
      $crud->set_relation('warranty_plan_id','warranty_plans','{name}');
      $crud->set_relation('appliance_type_id','appliance_types','{name}');
      $crud->set_relation('appliance_type_variation_id','appliance_types_variations','{name} {appliance_type_id}');
      $this->view_crud($crud->render(), 'warranty_plans_appliance_types');

    }


    public function simple_plans()
    {
        $crud = $this->crud_init('warranty_plans', ['name','price','status']);

        $crud->where('type', 'SIMPLE');



        $crud->fields('name','price' ,'type','_order', 'display_order_sequence_info' ,'appliance_types', 'warranty_items', 'status','note');

        if ($crud->getState()=='add')
            $crud->required_fields('name','price','status');

        $crud->unique_fields('name')
             ->field_type('created_at','hidden')
             ->field_type('updated_at','hidden')
             ->field_type('type', 'hidden', 'SIMPLE')
             ->unset_delete()
             ->display_as([
                'appliance_types' => 'Appliances Covered',
                '_order'          => 'Display Order',
                'price'           => 'Price (per month)'
            ]);


        if ($crud->getState()=='edit'){

            if($this->plan_current_status($this->uri->segment(4)) == 'ACTIVE'){
            //     $crud->field_type('appliance_types','readonly');
            }

             if($this->plan_current_status($this->uri->segment(4)) == 'RETIRED'){
                   $crud->field_type('_order','readonly')
                        ->field_type('display_order_sequence_info','readonly')
                        ->field_type('status','readonly')
                        ->field_type('appliance_types','readonly');
            }

            $crud->field_type('name','readonly')
                 ->field_type('price','readonly');
        }

        $crud->callback_before_update(array($this,'status_update_check'));

        $crud->callback_after_update(array($this,'status_update_check'));

        $crud->callback_field('note','Crud_helper::warranty_plans_info');

        $crud->callback_field('display_order_sequence_info','Crud_helper::display_order_info');

        $crud->set_relation_n_n(
            'appliance_types',
            'warranty_plans_appliance_types',
            'appliance_types',
            'warranty_plan_id',
            'appliance_type_id',
            'name'
        );

        $crud->set_relation_n_n(
            'warranty_items',
            'warranty_plans_warranty_items',
            'warranty_items',
            'warranty_plan_id',
            'warranty_item_id',
            'name'
        );

        $this->view_crud($crud->render(), 'Simple Plans');
    }

    public function combined_plans()
    {
        $crud = $this->crud_init('warranty_plans', ['name','price','status']);

        $crud->where('type', 'COMBINED');

        $crud->fields('name','price','type', '_order', 'display_order_sequence_info' ,'warranty_plans', 'status', 'note','appliance_types');

        $crud->unique_fields('name')
             ->field_type('created_at','hidden')
             ->field_type('updated_at','hidden')
             ->field_type('type', 'hidden', 'COMBINED')
             ->unset_delete()
             ->display_as([
                'warranty_plans' => 'Simple Plans',
                '_order' =>'Display Order',
                'price' => 'Price (per month)'
            ]);

        $crud->set_relation_n_n(
            'appliance_types',
            'warranty_plans_appliance_types',
            'appliance_types',
            'warranty_plan_id',
            'appliance_type_id',
            'name'
        );
        $crud->callback_before_update(array($this,'status_update_check'));

        $crud->callback_after_update(array($this,'status_update_check'));

        $crud->callback_field('note','Crud_helper::warranty_plans_info');

        $crud->callback_field('display_order_sequence_info','Crud_helper::display_order_info');

        $crud->set_relation_n_n(
            'warranty_plans',
            'combined_plans_simple_plans',
            'warranty_plans',
            'combined_plan_id',
            'simple_plan_id',
            'name',
            null,
            ['type' => 'simple'] // where
        );


        if ($crud->getState() == 'add')
            $crud->required_fields('name','price','status');

        if ($crud->getState() == 'edit'){

            // Restrictions during edit. making fields readonly
            // When status ACTIVE
            if($this->plan_current_status($this->uri->segment(4)) == 'ACTIVE'){
                 //$crud->field_type('warranty_plans','readonly');
            }

            // When status RETIRED
            if($this->plan_current_status($this->uri->segment(4)) == 'RETIRED'){
                $crud->field_type('_order','readonly')
                 ->field_type('display_order_sequence_info','readonly')
                 ->field_type('warranty_plans','readonly')
                 ->field_type('status','readonly');
            }

            $crud->field_type('name','readonly')
                ->field_type('price','readonly');
        }

        $this->view_crud($crud->render(), 'Combination Plans');
    }


    function plan_current_status($id){

        $this->db->from('warranty_plans');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data = $query->result();
        return $data[0]->status;
    }

    function status_update_check($post_array, $primary_key){

     $current_status = $this->plan_current_status($primary_key);

     if($post_array['status']=='DRAFT' && $current_status == 'ACTIVE')
        return false;

     return true;


    }


    public function _soft_deleted_repair_types($primary_key)
    {
      $this->db->where('id', $primary_key);
      $this->db->update('repair_types',array('_soft_deleted' => 1));
      return true;
    }

    public function time_slots()
    {
        $crud = $this->crud_init('time_slots', ['start','end']);

        $crud->where('_soft_deleted',0);
        $crud->field_type('_soft_deleted','hidden');
        $crud->callback_delete(array($this,'_soft_deleted_the_timeslots'));

        if($crud->getState()=='edit'){
            $crud->field_type('start','readonly');
            $crud->field_type('end','readonly');
        }

        $this->view_crud($crud->render(), 'Time Slots');
    }

    public function appliance_problems()
    {
        $crud = $this->crud_init('appliance_problems', ['problem','appliance_id']);

        $crud->field_type('created_at', 'hidden', date('yy-mm-dd H:I:S'));
        $crud->field_type('updated_at', 'hidden', date('yy-mm-dd H:I:S'));
        $crud->set_relation('appliance_id','appliance_types','{name}');
        $crud->display_as('appliance_id','Appliance Name');
        // $crud->unique_fields('problem');
        $this->view_crud($crud->render(), 'Appliance Problems');
    }

     public function _soft_deleted_the_timeslots($primary_key)
    {
        $this->db->where('id', $primary_key);
        $this->db->update('time_slots',array('_soft_deleted' => 1));
        return true;
    }


    // public function plans()
    // {
    //     $crud = $this->crud_init('plans', ['title','type','cost']);
    //     $crud->callback_before_delete([$this, 'before_delete_plan']);
    //     $crud->set_lang_string(
    //         'delete_error_message',
    //         'Cannot Delete Plan (Attached to a Contract). Try to inactivate plan.'
    //     );

    //     $this->view_crud($crud->render(), 'Appliance Types');
    // }

    public function before_delete_plan($plan_id)
    {
        $plan_attached = $this->db->select('count(id) as count')
                         ->from('contracts')
                         ->where('plan_id', $plan_id)->get()->result_array();

        if ($plan_attached[0]['count'] > 0)
            return False; // plan is attached cannot delete
        else
            return true;  // delete plan
    }

    public function job_appliances()
    {
        $crud = $this->crud_init('job_appliances', ['job_id','description', 'brand_name', 'model_number']);

        $this->view_crud($crud->render(), 'Job Appliances');
    }

    public function zipcodes()
    {
        $crud = $this->crud_init('zipcodes', ['zipcode','statename','cityname','latitude','longitude']);
        $crud->unset_edit();
        $crud->where('_soft_deleted',0);
        $crud->field_type('_soft_deleted','hidden');
        $crud->callback_delete(array($this,'_soft_deleted_the_zipcodes'));

        $crud->unique_fields('zipcode');
        $crud->required_fields('zipcode');

        // if($crud->getstate() == 'edit')
        //     $crud->field_type('zipcode','readonly');

        $crud->display_as([
            'zipcode'    => 'Code',
            'ziptype'    => 'Type',
            'cityname'   => 'City',
            'citytype'   => 'City Type',
            'countyname' => 'County Name',
            'countyfips' => 'County FIPS',
            'statename'  => 'State Name',
            'stateabbr'  => 'State Abbr',
            'statefips'  => 'State FIPS',
            'msacode'    => 'MSA Code',
            'areacode'   => 'Area Code',
            'utc'        => 'UTC',
            'dst'        => 'DST',
        ]);

        $this->view_crud($crud->render(), 'Zip Codes');
    }

    public function _soft_deleted_the_zipcodes($primary_key)
    {
        $this->db->where('id', $primary_key);
        $this->db->update('zipcodes',array('_soft_deleted' => 1));
        return true;
    }

}
