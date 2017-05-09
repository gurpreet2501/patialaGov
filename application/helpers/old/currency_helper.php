<?php
function yen_to_usd_rate(){ // Conversion YEN to USD Dollar 
	$ci =  get_instance();
	$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$cache_key = 'translation_'.md5("usd_price");
  if($cached = $ci->cache->get($cache_key))
     return $cached;
	
	$url = 'http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair in ("JPY", "USD")&env=store://datatables.org/alltableswithkeys'; 
	$xml = simplexml_load_file($url) or die("Exchange feed not loading!"); 
  $exchange = array(); 
	for($i=0; $i<2; $i++):
	    $name = (string)$xml->results->rate[$i]->Name;
	    
	    $rate = (string)$xml->results->rate[$i]->Rate;

	    $exchange[$name] = $rate; 
	endfor; 
	
	$usd=$exchange['USD/USD']/$exchange['USD/JPY'];
	$ci->cache->save($cache_key, $usd, 60);
	return $usd;

}

function yen_to_rbl(){
	$ci =  get_instance();
	$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$cache_key = 'translation_'.md5("rub_price");
  if($cached = $ci->cache->get($cache_key))
     return $cached;

	$url = 'http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair in ("JPY", "RUB")&env=store://datatables.org/alltableswithkeys'; 
	$xml = simplexml_load_file($url) or die("Exchange feed not loading!"); 
  $exchange = array(); 
	for($i=0; $i<2; $i++):
	    $name = (string)$xml->results->rate[$i]->Name;
	    
	    $rate = (string)$xml->results->rate[$i]->Rate;

	    $exchange[$name] = $rate; 
	endfor; 

	$rub=$exchange['USD/RUB']/$exchange['USD/JPY'];
  $ci->cache->save($cache_key, $rub, 60);
	return $rub;


}