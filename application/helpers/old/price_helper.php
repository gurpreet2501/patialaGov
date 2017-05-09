<?php
function calculate_price($price){
 
 $price=preg_replace('@[^0-9\.]+@i', '', $price);
 
 $lang=site_lang();
 $price=$price+(20/100)*$price;
 
 if($price < 10){
 	 $price= $price+10;
  }
  
 if($lang=='en'){
  	  $price='$'.number_format(yen_to_usd_rate() *  $price, 2);//Call to currecy helper to chnage yen to 
  }else{
  		$price='руб '.number_format(yen_to_rbl() *  $price, 2);//Call to currecy helper to chnage yen to rubal
  } 
  
  return $price;

}
