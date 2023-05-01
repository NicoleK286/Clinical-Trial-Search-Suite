<?php
	if(isset($_POST['submit'])){
		$email = 		$_POST['email'];
		$pass = 		$_POST['pwd'];
		$pass_rep = 	$_POST['pwd_repeat'];

		include '../inc/sql_connect.php';
		include '../inc/functions.inc.php';
		if (empty($email) || empty($pass) || empty($pass_rep)){
			mysqli_close($conn);
			header("location: ../main/register.php?error=emptyvalu");
			exit();
		}
		elseif (invalidEmail($email) !== false){
			mysqli_close($conn);
			header("location: ../main/register.php?error=invalidEmail");
			exit();
		}
		elseif (checkEmail($conn, $email) !== false){
			mysqli_close($conn);
			header("location: ../main/register.php?error=alreadyUser");
			exit();
		}
		elseif (invalidPWD($pass) !== false){
			mysqli_close($conn);
			header("location: ../main/register.php?error=invalidPWD");
			exit();
		}
		elseif (pwdMatch($pass, $pass_rep) !== false){
			mysqli_close($conn);
			header("location: ../main/register.php?error=passwordmis");
			exit();
		}
		createUser($conn, $email, $pass);	
	} else {
		header('location: ../main/register.php');
	}
?>	