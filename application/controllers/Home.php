<?php  defined('BASEPATH') OR exit('No direct script access allowed');
use App\Models;
class Home extends CI_Controller{

  function __construct(){
    parent::__construct();
  }
 
  public function index(){
    $this->load->view('home');
  }
  
 
}

