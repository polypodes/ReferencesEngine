<?php

$uploaddir = 'files/';

// GENERATE A NEW NAME
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$fName=uniqid().".".$ext;

$uploadfile = $uploaddir . $fName;

echo '<pre>';
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    $res = array(
    	'status' => 'success',
    	'fileName' => $fName
    );
} else {
    $res = array(
    	'status' => 'error'
    );
}

echo json_encode($res);
die();

?>