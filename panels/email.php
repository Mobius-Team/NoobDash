<?php
	if ( isset( $_SESSION['user_id'] ) ) {
		$agentID = $_SESSION['user_id'];
	} 
	else {
		exit();
	}
	
	$errorMessage = "";
	$updatedInfo = FALSE;
	
	include_once "includes/emailmagic.php";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//$updatedInfo = TRUE;
		//$errorMessage = "Error: This hasn't been coded yet!";
		
		
		$submittedEmail = $_POST["email"];
		
		if (filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
			$success = updateEmailAddress( $agentID, $submittedEmail );
			if( $success === TRUE ) {
				$updatedInfo = TRUE;
			}
			else $errorMessage = $success;
		}
		else
		{
			$errorMessage = "Error: Invalid email address!";
		}
	}
	
	$emailAddress = getEmailAddress( $agentID );
?>

<form method="post" action=""> 
	<div align="center">
		<h4>Email Settings</h4>
	</div>
	<div class="loser">
		<br><br>
		<div style="margin-left: 10%;">
			<label>Email Address:</label>
			
			<?php
				echo '<input style="width: 300px;" type="text" name="email" value="' . $emailAddress . '">';
			?>
		</div>
		
		<br><br>
		<div align="center">
		
		<?php
			if( $updatedInfo )
			{
				echo '<font color="green">Settings updated successfully!</font><br>';
			}
			else if( $errorMessage != "" )
			{
				echo '<font color="red">' . $errorMessage . '</font><br>';
			}
			else echo '<br>';
		?>
			<br>
			<input type="submit" name="submit" value="Update Settings" >  
		</div>
	</div>
</form>