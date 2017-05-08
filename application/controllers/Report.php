<?php defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Report extends MY_Controller
{
       
    public function index()
    {
      $start_date = date("Y-m-d");

      $end_date = '0000-00-00';
      
      if(!empty($_GET['start_date'])){
        $start_date = date('Y-m-d' ,strtotime($_GET['start_date']));
        $end_date = date('Y-m-d' ,strtotime($_GET['end_date']));
      }

    	$t = "SELECT storage.id,storage.bags, storage.chamber,storage.dispatch, potatoes.name, records.Stacker, records.owner, records.cnumber as customer_no, records.condition,storage.date FROM `storage` left join `potatoes` on storage.potato_type=potatoes.id left join `records` on storage.record_id=records.id where storage.date >= '".$start_date."' AND storage.date <= '".$end_date."'";

      $query = $this->db->query($t);
           
      $data = $query->result_array();
       
      $this->load->view('custom-crud',[
            'template' => 'admin/report',
            'data' => $data
            ]);
    }

}
