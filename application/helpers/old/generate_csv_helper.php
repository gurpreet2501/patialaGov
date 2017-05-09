<?php

function create_csv($data){
   echo "<pre>";
   print_r($data);
  $list = array (
	    array('Sno ', 'name', 'title', 'target'),
	);

	$fp = fopen(APPPATH.'/csv/file.csv', 'wb');

	foreach ($list as $fields) {
	    fputcsv($fp, $fields);
	}

	fclose($fp);


   exit;

}