<?php

//when setting attribute value
function av($val){
  return htmlspecialchars($val,ENT_QUOTES,false);
}


//safe text printing. encodes html
function t($val){
  return htmlentities($val);
}

function date1($date){
  return date('g:i a - M j, Y',strtotime($date));
}

function date2($date){
  return date('M j, Y',strtotime($date));
}