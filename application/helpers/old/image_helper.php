<?php

function image($url){
  $file_name = image_name($url);
  $file_path = APPPATH.'../images/cached/'.$file_name;
  if(!file_exists($file_path))
    image_download($url, $file_path);
  return image_local_url($file_name);
}

function image_download($url,$path){
  
  $ch = curl_init($url);
  $fp = fopen($path, "w");

  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);

  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
}

function image_local_url($file_name){
  return base_url('images/cached/'.$file_name);
}

function image_name($url){
  $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
  if(!in_array($extension,array('png','jpg','jpeg','gif')))
    $extension = 'jpg';
  return md5($url).".{$extension}";
}
