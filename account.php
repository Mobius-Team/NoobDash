<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	</head>
	<body>
<?php
	session_start();
	
	if ( isset( $_SESSION['user_id'] ) ) {
		// Grab user data from the database using the user_id
		// Let them access the "logged in only" pages
		$agentID = $_SESSION['user_id'];
	} 
	else {
		// Redirect them to the login page
		header("Location: /login");
		exit();
	}
	
	$path = $_SERVER['REQUEST_URI'];
	$parse = explode( "/", $path );
	$page = NULL;
	if( count( $parse ) == 3 ) 
	{
		$page = $parse[2];
	}
?>
	<div class="top-right"><a href='/includes/logout.php'>Logout</a></div>
	<div><a href='/'>Back</a></div>
	
	<div id="main-pane">
		<div id="account-menu">
		<ul>
			<li><a href="/account/email">Email Settings</a>
			</li>
			<li><a href="/account/password">Password Settings</a>
			</li>
			<li><a href="/account/rsa">RSA Settings</a>
			</li>
		</ul>
		</div>
		
		<br>
		
		<?php
			if($page === "email" || $page === "" || $page === NULL) 
				require('panels/email.php');
			else if($page === "password") 
				require('panels/password.php');
			else if($page === "rsa") 
				require('panels/rsa.php');
			else echo '<div align="center">Bugh, you must be dutch!</div>';
		?>
		
	</div>
	
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>