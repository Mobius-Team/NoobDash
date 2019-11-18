<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	<style>
	body {
		background: #555;
	}
	.error {color: #FF0000;}
	.success {color: #00FF00;}		
	.box
	{
		background: #888;
		position: fixed; /* or absolute */
		height: 370px;
		width: 420px;
		top: 50%;
		left: 50%;
		margin-top: -160px;
		margin-left: -210px;
	}
	label { float: left; width: 150px; text-align: right; }
	input[type=text] { width: 200px; }
	input[type=password] { width: 200px; }
	</style>
	</head>
	<body>
	<div><a href='/'>Back</a></div>
<?php
	session_start();
	
	function validateInfo( $username, $password, $confirm_pass, $email, $tos )
	{
		if ( filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE ) 
		{
			return "Invalid email address";
		}
		
		if ( empty($username) ) 
		{
			return "Username is required";
		}
		else
		{
			if ( !preg_match( "/^[a-zA-Z0-9 ]*$/", $username ) )
			{
				return "Only letters and numbers allowed in username";
			}
			else {
				$parse = explode( " ", $username );
				$count = count( $parse );
				
				if( $count != 1 && $count != 2 )
				{
					return "Username cannot be more than two names";
				}
			}
		}
	  
		if ( empty( $password ) ) 
		{
			return "Password is required";
		}
		
		if( $password != $confirm_pass )
		{
			return "Passwords do not match";
		}
		
		if( $tos === FALSE )
		{
			return "You must agree to the Terms of Service";
		}
		
		return TRUE;
	}
	
	$genericErr = $username = $email = $firstname = $lastname = $password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$username = htmlspecialchars( $_POST["username"] );
		$password = htmlspecialchars( $_POST["password"] );
		$confirm_password = htmlspecialchars( $_POST["confirm_password"] );
		$email = htmlspecialchars( $_POST["email"] );
		$agree_to_tos = $_POST["agree_to_tos"] === "1";
		
		$check_data = validateInfo( $username, $password, $confirm_password, $email, $agree_to_tos );
		
		if( $check_data === TRUE )
		{
			$parse = explode( " ", $username );
			$count = count( $parse );
			
			if( $count == 1 )
			{
				$firstname = $parse[0];
				$lastname = "Resident";
			}
			else if( $count == 2 )
			{
				$firstname = $parse[0];
				$lastname = $parse[1];
			}
			
			if(!empty($firstname) && !empty($lastname) && !empty($password))
			{
				include_once "includes/accountmagic.php";
				
				$create_info = "";
				$create_success = createUser( $firstname, $lastname, $password, $email, $create_info );
				
				if( $create_success === TRUE ) 
				{
					$_SESSION['user_id'] = $create_info;
					$_SESSION['user_level'] = 0;
					
					header("Location: " . WebsiteURL);
					exit();
				}
				else
				{
					$genericErr = $create_success;
				}
			}
		}
		else
		{
			$genericErr = $check_data;
		}
	}
?>

	<div class="box" align="center">
		<h2>OpenSim Signup Example</h2>
		<form method="post" action="">  
			<label>Email Address:</label><input type="text" name="email" value="<?php echo $email; ?>">
			<br><br>
			<label>Username:</label><input type="text" name="username" value="<?php echo $username; ?>">
			<br><br>
			<label>Password:</label><input type="password" name="password" value="">
			<br><br>
			<label>Confirm Password:</label><input type="password" name="confirm_password" value="">
			<br><br>
			<input type="checkbox" name="agree_to_tos" value="1">I agree to the <a href='/tos' target="_blank">Terms of Service</a>
			<br><br>
			<span class="error"><?php echo $genericErr;?></span><br>
			<br>
			<input type="submit" name="submit" value="Create Account">  
			<br>
			<br>
			<a href='/login'>Already have an account?</a>
		</form>
	</div>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>