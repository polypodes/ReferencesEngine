<?php 
	error_reporting(0);

	if(unlink(dirname(__FILE__) . "/data/" . $_POST['file'])){
		echo json_encode(array('error' => 'ok'));
	}else{
		echo json_encode(array('error' => 'noexists'));
	}
?>