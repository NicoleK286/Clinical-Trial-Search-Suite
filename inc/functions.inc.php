<?php
	function invalidEmail($e){
		$result = False;
		if (!filter_var($e, FILTER_VALIDATE_EMAIL)){
			$result = TRUE;
		}
		return $result;
	}
	
	function invalidPWD($p){
		$result = False;
		$uppercase = preg_match('@[A-Z]@', $p);
		$lowercase = preg_match('@[a-z]@', $p);
		$number    = preg_match('@[0-9]@', $p);
		$specialChars = preg_match('@[^\w]@', $p);

		if(!$uppercase || !$lowercase || !$number || 
		   !$specialChars || strlen($p) < 8) {
			$result = TRUE;
		}
		return $result;
	}
	
	
	function pwdMatch($p, $pr) {
		$result = False;
		if($p !== $pr){
			$result = TRUE;
		}
		return $result;

	}

	function checkEmail($conn, $email){
		$result = False;
		$sql = "SELECT * FROM users WHERE u_email = ?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header('location: ../main/register.php?error=stmtfailed');
			exit();
		}
		mysqli_stmt_bind_param($stmt, 's', $email);
		mysqli_stmt_execute($stmt);
		$ret = mysqli_stmt_get_result($stmt);
		if (mysqli_num_rows($ret) != 0){
			$result = TRUE;
		}
		mysqli_stmt_close($stmt);
		return $result;
	}	
			
	function createUser($conn, $email, $pwd){
		$pwd = password_hash($pwd, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (u_email, u_PWD) VALUES (?, ?);";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header('location: ../main/register.php?error=stmtfailed');
			exit();
		}
		mysqli_stmt_bind_param($stmt, 'ss' , $email, $pwd);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		header('location: ../main/signin.php?error=none');
	}

	function loginUser($conn, $email, $pass){
		$sql = "SELECT u_id, u_PWD FROM users WHERE u_email = ?";
		$stmt = mysqli_stmt_init($conn);
		echo $pass;
		echo $email;
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header('location: ../signin.php?error=stmtfailed');
			exit();
		}
		mysqli_stmt_bind_param($stmt, 's' , $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if (mysqli_num_rows($result)===1){
			$row = mysqli_fetch_assoc($result);
			$hashed_pwd = $row['u_PWD'];
			if (password_verify($pass, $hashed_pwd)){
				$_SESSION['uid'] = $row['u_id'];
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				header('location: ../main/homepage.php');
			}
		}else{
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header('location: ../main/signin.php?error=invalidUser');
		}
	}

?>