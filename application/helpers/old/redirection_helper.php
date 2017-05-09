<?php
function redirection_handler($lang){
	$path='';
	$CI=get_instance();
	$data=$CI->uri->segment_array();   
  $i=2;
  $path.=site_url();
  $path.='/'.$lang;
  while(!empty($data[$i])){
  	$path.='/'.$data[$i];
  	$i++;
  }	
  return $path;
}