<?php
	$server = 'localhost';
	$username = 'ajettpac';
	$password = 'itemizes sponsorship descents';
	$db = 'ajettpac_db';
	$conn = mysqli_connect($server, $username, $password, $db);
	if (!$conn){
		die('Connection failed: ' . mysqli_connect_error());
	}
?>