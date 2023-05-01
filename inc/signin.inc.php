<?php
	if(isset($_POST['submit'])){
		$user = 		$_POST['log_u'];
		$pass = 		$_POST['log_pwd'];
		$robot =		$_POST['robot'];
		session_start();
		include '../inc/sql_connect.php';
		include '../inc/functions.inc.php';

		if (empty($user) || empty($pass)|| empty($robot)){
			mysqli_close($conn);
			header("location: ../main/signin.php?error=emptyInput");
			exit();
		}elseif($robot !== $_SESSION['cap_code']){
			mysqli_close($conn);
			header("location: ../main/signin.php?error=invalidCaptcha");
			exit();
		}else {
			loginUser($conn, $user, $pass);
		}
	}else {
		header('location: ../main/signin.php');
	}
?>