<?php
	if ( isset( $_SESSION['user_id'] ) ) {
		// Grab user data from the database using the user_id
		// Let them access the "logged in only" pages
		$agentID = $_SESSION['user_id'];
	} 
	else {
		exit();
	}
	
	include "includes/rsamagic.php";
	
	$errorMessage = $successMessage = "";
	$updatedInfo = FALSE;
	
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
			$errorMessage = 'Error: A key was not provided!';
		} 
		else
		{
			$success = changeRSASettings( $agentID, $submittedKey, $disablePassword );
			
			if( $success === TRUE )
				$updatedInfo = TRUE;
			else
				$errorMessage = $success;
		}
	}
	
	$rsaData = getRSAData( $agentID );
	$rsaOnly = $rsaData["disable"];
	$rsaKey = $rsaData["key"];
?>

<div align="center">
	<h4>RSA Login Settings</h4>
	<form method="post" action="">  
		<?php 
		echo '<div style="width: 550px;" align="left">Public Key:</a></div>
			<textarea name="rsaKey" style="width: 550px; height: 100px" rows="10" cols="80" ';
		if( $rsaOnly == "1" )
			echo 'disabled';
		echo '>' . $rsaKey .'</textarea>';
		
		echo '<br>';
		
		echo '<br><input type="checkbox" name="disable_password_check" value="1" ';
		if( $rsaOnly == "1" )
			echo 'checked disabled';
		echo '>Disable Password Login<br>';
		
		echo '<br>';
		
		if( $updatedInfo )
		{
			echo '<font color="green">Settings updated successfully!</font><br>';
		}
		else if( $errorMessage != "" )
		{
			echo '<font color="red">' . $errorMessage . '</font><br>';
		}
		else echo '<br>';
		
		if( !empty( $rsaKey ) && $rsaOnly != 1 )
		{
			echo '<font color="orange">Warning: Please make sure that you test that you can log in with your key before disabling password logins!</font><br>';
		}
		else echo '<br>';
		
		echo '<br><br><input type="submit" name="submit" value="Update Settings" ';
		if( $rsaOnly == "1" )
			echo 'disabled';
		echo '>';
		?>
	</form>
	<p style="width: 80%;">
	</p>
</div>