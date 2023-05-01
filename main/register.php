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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
	$title = 'Registration Page';
	include_once '../inc/header.inc.php';
	if (isset($_SESSION['uid'])){
		header("location: ../main/homepage.php");
	}

?>
<!-- gives access to linked html stuff, including css-links-->
<div class="container-fluid">
<div id ='main_page'>
<h2>Create Account</h2>
<p>Password requirements</p>
<ul>
<li>Minimum of 8 characters</li>
<li>A lowercase character</li>
<li>An uppercase character</li>
<li>A numeric character</li>
<li>A special character</li>
</ul>
<?php
if(isset($_GET['error'])){
		if ($_GET['error'] == 'emptyvalu'){
			echo "<p class='error_msg'>You must fill all values</p>";
		}elseif ($_GET['error'] == 'invalidEmail'){
			echo "<p class='error_msg'>That is not a valid Email!</p>";
		}elseif($_GET['error'] == 'invalidPWD'){
			echo "<p class='error_msg'>Password does not meet requirements!</p>";
		}elseif ($_GET['error'] == 'passwordmis'){
			echo "<p class='error_msg'>You must make sure to confirm you password!</p>";
		}elseif ($_GET['error'] == 'alreadyUser'){
			echo "<p class='error_msg'>That email is already taken!</p>";
		}elseif ($_GET['error'] == 'stmtfailed'){
			echo "<p class='error_msg'>Something went wrong, please try again</p>";
		}
	}	
?>

<form action = '../inc/register.inc.php' method = 'post'>
<label for='user'>Email</label><br>
<input type = 'text' name='email' id = 'user' placeholder= 'Email'><br>
<label for = 'pwd'>Password</label><br>
<input type = 'password' name='pwd' id = 'pwd' placeholder='Password'><br>
<label for='rpwd'>Repat Password</label><br>
<input type = 'password' name='pwd_repeat' id = 'rpwd' placeholder='Repeat Password'><br>
<input type='submit' name='submit' value='Sign Up'>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
