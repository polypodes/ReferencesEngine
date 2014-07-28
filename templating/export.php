<?php 
	$file_title = $_POST['file_title'].".json";

	if($_POST['overwrite']=='false'){
		$_POST['overwrite']=false;
	}else{
		$_POST['overwrite']=true;
	}

	$write=false;

	if (file_exists('data/'.$file_title)){
		if($_POST['overwrite']==true){
			$write=true;
		}
	}else{
		$write=true;
	}

	if($write){
		$fp = fopen('data/'.$file_title, 'wb');
		fwrite($fp, json_encode($_POST['data']));
		fclose($fp);

		echo json_encode(array('error' => 'ok'));
	}else{
		echo json_encode(array('error' => 'exists'));
	}
?>