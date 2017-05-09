<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = function(){
 
  // if(is_role('plant_manager') && (user_data('username') == 'khanna')){
  //   redirect(base_url().'/khanna.php/admin');
  //   exit;
  // }

  // if(is_role('depot')){
  //   redirect(base_url().'/depot.php/admin');
  //   exit;
  // }
};
