<?php

if(!function_exists('curl_reset')){
  
  function curl_reset($resource){
    curl_setopt($resource, CURLOPT_HTTPGET, 1);
    curl_setopt($resource, CURLOPT_POST, false);
  }
  
}