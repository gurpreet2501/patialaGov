<?php
use App\Models\Users;
function user_type($id){
	$CI = get_instance();
	$user = obj('users')->read(['select' => ['customer_type'],
                               'where'  => ['id',$id]
    ]);
    return  $user[0]['customer_type'];
}

function get_users(){
  $CI = get_instance();
  $users = obj('users')->read(['select' => ['^*'],
                               'where'  => ['role','customer']
    ]);
  
    return  $users;
}

function is_depot(){
  $CI = get_instance();
  $users = obj('users')->read(['select' => ['capability'],
                               'where'  => ['id', user_id()]
    ]);

  return (Boolean)($users[0]['capability'] == 'depot');
  
}

function get_user_full_name($id){
	$user = Users::select('full_name')->where('id',$id)->first();
  return isset($user->full_name) ? $user->full_name : '';
}

