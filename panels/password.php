<?php
	if ( isset( $_SESSION['user_id'] ) ) {
		// Grab user data from the database using the user_id
		// Let them access the "logged in only" pages
		$agentID = $_SESSION['user_id'];
	} 
	else {
		exit();
	}
	
	$errorMessage = "";
	$updatedInfo = FALSE;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		include "includes/passwordmagic.php";
		
		$currentPassword = $_POST["current_password"];
		$newPassword = $_POST["new_password"];
		$confirmPassword = $_POST["confirm_password"];
		
		if( empty( $currentPassword ) )
		{
			$errorMessage = "No password entered";
		}
		else if( empty( $newPassword ) )
		{
			$errorMessage = "New password is not valid!";
		}
		else if( $newPassword != $confirmPassword )
		{
			$errorMessage = "Passwords do not match!";
		}
		else
		{
			$success = changeAccountPassword( $agentID, $currentPassword, $confirmPassword );
			if( $success === TRUE )
			{
				$updatedInfo = TRUE;
			}
			else $errorMessage = $success;
		}
	}
?>

<div align="center" class="test_shit">
	<h4>Change Password</h4>
	<form method="post" action=""> 
		<br><br>
		<label>Password:</label><input type="password" name="current_password" value="" style="width: 250px;">
		<br><br>
		<label>New Password:</label><input type="password" name="new_password" value="" style="width: 250px;">
		<br><br>
		<label>Confirm New Password:</label><input type="password" name="confirm_password" value="" style="width: 250px;">
		<br><br>
		<?php
			if( $updatedInfo )
			{
				echo '<font color="green">Settings updated successfully!</font><br>';
			}
			else if( $errorMessage != "" )
			{
				echo '<font color="red">Error: ' . $errorMessage . '</font><br>';
			}
			else echo '<br>';
		?>
		<br>
		<input type="submit" name="submit" value="Change Password">
	</form>
</div>