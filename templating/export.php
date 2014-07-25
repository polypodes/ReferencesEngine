<?php 
	$file_title = $_POST['file_title'].".json";

	if (file_exists('data/'.$file_title) && $_POST['overwrite']!=true){
		echo json_encode(array('error' => 'exists'));
	}else{
		$fp = fopen('data/'.$file_title, 'wb');
		fwrite($fp, json_encode($_POST['data']));
		fclose($fp);

		echo json_encode(array('error' => 'ok'));
	}
?>