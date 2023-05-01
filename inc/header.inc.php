<?php
	session_start();
	//will do this for every page
?>
<meta charset = 'utf-8'>
<title><?php echo $title; ?></title>
<link rel='stylesheet' type = 'text/css' href='../css/header_style.css'>
</head>
<body>
<div id='navbar'>
<ul class = 'nav'>
	<li><a href = '../main/homepage.php'>Home</a></li>
		<?php
			if (isset($_SESSION['uid'])){
				$logged_in = "<li><a href = '../main/ProjectPracticeForm.php'>Search Trials</a></li>" .
				"<li><a href = '../inc/logout.inc.php'>Logout</a></li>";
				
				echo $logged_in;
			} else {
				$logged_out = "<li><a href = '../main/signin.php'>Sign In</a></li>" .
						"<li><a href = '../main/register.php'>Register</a></li>";
				echo $logged_out;
			}
		?>
</ul>
<div class='clear'></div>
</div>