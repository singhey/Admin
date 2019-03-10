<?php
	
	$serverName = 'localhost';
	$username = "root";
	$password = "youdontknow";
	$db = "hotel";
	$con = mysqli_connect($serverName, $username, $password, $db) or die("cannot establish database sonnection");
	if(!$con){
		echo "error connecting to database";
		mysqli_close($con) or die("Database not closed");
		exit;
	}

?>