<?php

function convert_weight($from,$to,$weight){
  $func = strtolower(str_replace(' ','_',$from)).'_to_'.strtolower(str_replace(' ','_',$to));

  if(function_exists($func))
    return $func($weight);
  return -1;
}

function convert_weight_multi($from,$to,$weight, $to2=null, $to3=null){
  if(is_null($to2) && is_null($to3))
    return [convert_weight($from,$to,$weight), $to];

  $converted = convert_weight($from,$to,$weight);
  if($converted > 0)
    return [$converted, $to];    

  $converted = convert_weight($from,$to2,$weight);
  if($converted > 0)
    return [$converted, $to2];      

  $converted = convert_weight($from,$to3,$weight);
  if($converted > 0)
    return [$converted, $to3];      

  return [$weight, $from];
}


function get_weight_unit($from){
	 if($from == 'Liter' || $from == 'Milliliter')
        $conv_unit = 'kiloliter';
      else
        $conv_unit = 'metric ton';
  
  return $conv_unit == 'kiloliter' ? 'Kilo Liter' : 'Metric Ton';
}


function kilogram_to_metric_ton($num){
  $cal = floatval($num) * 0.001;
  return round($cal, 2);
}
function gram_to_metric_ton($num){
  $cal = floatval($num) * 0.000001;
  return round($cal, 2);
}
function milligram_to_metric_ton($num){
  $cal = floatval($num) * 0.000000001;
  return round($cal, 2);
}

function liter_to_kiloliter($num){
  $cal =  floatval($num) * 0.001;
  return round($cal, 2);
}

function milliliter_to_kiloliter($num){
  $cal = floatval($num) * 0.000001;
  return round($cal, 2);
}

function liter_to_liter($num){
  return round(floatval($num), 2);
}

function milliliter_to_milliliter($num){
  return round(floatval($num), 2);
}

function milliliter_to_liter($num){
  return round(floatval($num)*0.001, 2);
}

function liter_to_milliliter($num){
  return round(floatval($num)/0.001, 2);
}

function kiloliter_to_milliliter($num){
  $liter = floatval($num)*0.001;
  return liter_to_milliliter($liter);
}

function metric_ton_to_gram($num){
  $kilogram =  metric_ton_to_kilogram($num);
  return kilogram_to_gram($kilogram);
}

function metric_ton_to_kilogram($num){
  return round(floatval($num)/0.001, 2);
}

function kilogram_to_gram($num){
  return round(floatval($num)/0.001, 2);
}

function kilogram_to_kilogram($num){
 return round(floatval($num), 2); 
}

function gram_to_gram($num){
  return round(floatval($num), 2);
}



