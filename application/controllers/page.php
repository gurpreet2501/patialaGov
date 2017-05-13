<?php  defined('BASEPATH') OR exit('No direct script access allowed');

use App\Models;
class Page extends CI_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  //$empid coming from search page
  public function index($post_name){
    $this->load->view('pages/page-basic-structure',['page_name' => $post_name]);
  }
  
}