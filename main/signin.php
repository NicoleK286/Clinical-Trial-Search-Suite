<!DOCTYPE html>
<html>
<head>
<style type='text/css'>
body {
   background-image: url('../main/image_fittedv2.jpg'); 
   background-repeat: y-repeat;
}

.error_msg {
 	color: red;
}
</style>
<?php
	$title = 'Signin Page';
	include_once '../inc/header.inc.php';
	if (isset($_SESSION['uid'])){
		header("location: homepage.php");
	}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<div class="container-fluid">
<div id = 'main_page'>
<h2>Sign In</h2>
<?php
if(isset($_GET['error'])){
	if($_GET['error'] == 'stmtfailed'){
		echo "<p class='error_msg'>We are sorry, something has gone wrong</p>";
	}elseif ($_GET['error'] == 'emptyInput'){
		echo "<p class='error_msg'>You must put an in credentials to sign in";
	}elseif ($_GET['error'] == 'invalidUser'){
		echo "<p class='error_msg'>That is not a valid login!</p>";
	}elseif ($_GET['error'] == 'invalidCaptcha'){
		echo "<p class='error_msg'>You have not proved you are human!</p>";
	}elseif ($_GET['error'] == 'none'){
		echo "<p>You are now registered! Please feel free to sign in.</p>";
	}
}
?>
<form method='post' action = '../inc/signin.inc.php'>
	<label for='log_u'>Username</label><br>
	<input type='text' id='log_u' name='log_u'><br><br>
	<label for='log_pwd'>Password</label><br>
	<input type='password' id='log_pwd' name='log_pwd'><br><br>
	<label for='robot'>Prove you are not a robot:</label><br>
	<input type='text' id='robot' name='robot'><br>
	<p id="demo"><img src='../inc/captcha.inc.php' height='100' width='200'></p>
	<button type = 'button' onclick="myFunction()">Click For New Captcha</button>
	<input type='submit' name='submit' value='Login'>
</div>
</div>
<script>
        function myFunction() {
            var c = "../inc/captcha.inc.php";
            document.getElementById("demo").innerHTML = "<img src=" + c + " height='100' width='200'/>";
        }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
