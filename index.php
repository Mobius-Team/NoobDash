<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	</head>
	<body>
<?php
	session_start();
	
	if ( isset( $_SESSION['user_id'] ) ) {
		if ( isset( $_SESSION['user_level'] ) )  {
			if( $_SESSION['user_level'] > 0 ) {
				echo '<a href="/reports">Abuse Reports</a>&nbsp;&nbsp;&nbsp;';
			}
		}
		
		echo '<div class="top-right">Welcome, <a href="/account">' . $_SESSION['user_name'] . '</a>&nbsp;&nbsp;&nbsp;
			<a href="includes/logout.php">Logout</a>
		</div>';
	}
	else {
		echo '<div class="top-right"><a href="/create">Create Account</a>&nbsp;&nbsp;&nbsp;
			<a href="/login">Login</a></div>';
	}
?>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>