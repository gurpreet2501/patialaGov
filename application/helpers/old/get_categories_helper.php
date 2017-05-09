<?php
function cat_names(){
   
 $CI=get_instance();
 $CI->load->database();
 $CI->db->select("id, category_name");
 $CI->db->from('categories');
 $query = $CI->db->get();
 return $query->result(); 
 

}
