<?php
	$response=$_POST;
	$fp = fopen('book.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);
?>