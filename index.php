<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	</head>
	<body>
<?php
	session_start();
	
	if ( isset( $_SESSION['user_id'] ) ) {
		echo '<div class="top-right"><a href="includes/logout.php">Logout</a></div>';
		
		echo '<a href="/rsa">RSA Settings</a>';
		
		echo '<br>';
		
		if ( isset( $_SESSION['user_level'] ) )  {
			if( $_SESSION['user_level'] > 0 ) {
				echo '<br><a href="/reports">Abuse Reports</a>';
			}
		}
	}
	else {
		echo '<div class="top-right"><a href="/login">Login</a></div>';
	}
?>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>