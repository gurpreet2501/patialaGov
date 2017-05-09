<?php

function lng_translate($text,$des_lang,$source_lng){
  require_once APPPATH.'translator/mstranslation.class.php';
	$ci =  get_instance();
	$ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$cache_key = 'translation_'.md5("{$text};{$des_lang};{$source_lng}");
  if($cached = $ci->cache->get($cache_key))
      return $cached;

	$translateThis = new TranslateMe("RsgKXwP+ELNUMOpKwj4+x8cPubrrg0ey9dkUcU56KFc");  
	$text = $translateThis->translate($text, $des_lang, $source_lng); //Japanese to English
  
	$ci->cache->save($cache_key, $text, 3600*24*30*12*10);
	return $text;

}
