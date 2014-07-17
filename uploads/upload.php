<?php

$uploaddir = 'files/';

// GENERATE A NEW NAME
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$fName=uniqid().".".$ext;

$fileName=$_FILES['file']['name'];
$fileType=$_FILES['file']['type'];
$fileSize=$_FILES['file']['size'];

$uploadfile = $uploaddir . $fName;
$error=false;

// SECURITY CHECKS 

// Check size
$max_size=3500000;
if($fileSize>$max_size){
	$error=true;
}

// Check extension
$whitelist = array(".jpg",".jpeg",".gif",".png"); 
if (!(in_array(".".$ext, $whitelist))) {
	$error=true;
}

// Check type
$pos = strpos($fileType,'image');
if($pos === false) {
	$error=true;
}

// Check image format
$imageinfo = getimagesize($_FILES['file']['tmp_name']);
if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg'&& $imageinfo['mime'] != 'image/jpg'&& $imageinfo['mime'] != 'image/png') {
	$error=true;
}

// Check double file type
if(substr_count($fileType, '/')>1){
	$error = true;
}

if(!$error){
	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
	    $res = array(
	    	'status' => 'success',
	    	'fileName' => $fName
	    );
	}else{
		$error=true;
	}
}
if($error){
    $res = array(
    	'status' => 'error'
    );
}

echo json_encode($res);
die();

?>