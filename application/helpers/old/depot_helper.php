<?php

function get_depots_list($plant_id){
  return obj('users')->read([
    'select' => ['id','username'],
    'where'   =>['role','depot'],
  ]);
}

function depots_and_plant_list(){
    return obj('users')->read(array(
          'select'  => array('id','username','capability'),
          'where'   => [
          	array('role','plant_manager'),
          	'OR',
          	array('role','depot'),
          	]
    ));
}