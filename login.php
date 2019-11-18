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
		height: 250px;
		width: 420px;
		top: 50%;
		left: 50%;
		margin-top: -110px;
		margin-left: -210px;
	}
	</style>
	</head>
	<body>
	<div><a href='/'>Back</a></div>
<?php
	session_start();
	
	$genericErr = $username = $firstname = $lastname = $password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["username"])) {
			$genericErr = "Username is required";
		} else {
			$username = htmlspecialchars($_POST["username"]);

			if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username)) {
				$genericErr = "Only letters and numbers allowed";
			}
			else {
				$parse = explode( " ", $username );
				$count = count( $parse );

				if( $count == 1 )
				{
					$firstname = $parse[ 0 ];
					$lastname = "Resident";
				}
				else if($count == 2)
				{
					$firstname = $parse[ 0 ];
					$lastname = $parse[ 1 ];
				}
				else
				{
					$genericErr = "Username cannot be more than two names";
				}
			}
		}
	  
		if (empty($_POST["password"])) {
			$genericErr = "Password is required";
		} else {
			$password = htmlspecialchars($_POST["password"]);
		}


		if(!empty($firstname) && !empty($lastname) && !empty($password))
		{
			include_once "includes/login.php";
			$loginResult = loginWithPassword( $firstname, $lastname, $password );
			
			if( $loginResult === TRUE ) {
				header("Location: " . WebsiteURL);
				exit();
			}
			else
			{
				$genericErr = $loginResult;
			}
		}
	}
?>

	<div class="box" align="center">
		<h2>OpenSim Login Example</h2>
		<form method="post" action="">  
			Username: <input type="text" name="username" value="">
			<br><br>
			Password: <input type="password" name="password" value="">
			<br><br>
			<span class="error"><?php echo $genericErr;?></span><br>
			<br>
			<input type="submit" name="submit" value="Login">
			<br>
			<br>
			<a href='/create'>Need an account?</a>
		</form>
	</div>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>