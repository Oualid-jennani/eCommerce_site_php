<?php
	$host="localhost";
	$user="root";
	$psw="1996@walid";
    $db="planetshop";
    
	$cn = mysqli_connect($host,$user,$psw,$db);
	$cn->set_charset("utf8");

	if(!$cn){ die(mysqli_connect_error());}
?>