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
?>
	<div class="top-right"><a href='/includes/logout.php'>Logout</a></div>
	<div><a href='/'>Back</a></div>
<?php
	include "includes/rsamagic.php";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$submittedKey = $_POST["rsaKey"];
		
		$submittedKey = str_replace("-----BEGIN PUBLIC KEY-----", "", $submittedKey);
		$submittedKey = str_replace("-----END PUBLIC KEY-----", "", $submittedKey);
		$submittedKey = trim(preg_replace('/\s+/', '', $submittedKey));
		
		if( isset( $_POST["disable_password_check"] ) )
			if($_POST["disable_password_check"]  === "1")
				$disablePassword = 1;
			else $disablePassword = 0;
		else $disablePassword = 0;
		
		if (empty($submittedKey)) {
			echo '<br><font color="red">Error: A key was not provided!</font>';
		} 
		else
		{
			$success = changeRSASettings( $agentID, $submittedKey, $disablePassword );
			
			if( $success === TRUE )
				echo '<br><font color="green">Settings updated successfully!</font>';
			else
				echo '<br><font color="red">' . $success . '</font>';
		}
	}
	
	$rsaData = getRSAData( $agentID );
	$rsaOnly = $rsaData["disable"];
	$rsaKey = $rsaData["key"];
	
	echo '<br>';

	if( !empty( $rsaKey ) && $rsaOnly != 1 )
	{
		echo '<font color="orange">Warning: Please make sure that you test that you can log in with your key before disabling password logins!</font><br>';
	}
?>
	<br>
	<form method="post" action="">  
		<?php 
		echo '<input type="checkbox" name="disable_password_check" value="1" ';
		if( $rsaOnly == "1" )
			echo 'checked disabled';
		echo '>Disable Password Login<br>';
		
		echo '<br>Public Key:<br><textarea name="rsaKey" style="width: 500px; height: 100px" rows="10" cols="80" ';
		if( $rsaOnly == "1" )
			echo 'disabled';
		echo '>' . $rsaKey .'</textarea>';

		echo '<br><br><input type="submit" name="submit" value="Update Settings" ';
		if( $rsaOnly == "1" )
			echo 'disabled';
		echo '>';
		?>
	</form>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>