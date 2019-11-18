<?php
	function updateEmailAddress( $userID, $emailAddress )
	{
		include_once "includes/config.php";
		
		// Create connection
		$conn = new mysqli( SQLServerName, SQLUserName, SQLPassword, SQLDatabase );

		// Check connection
		if ( $conn->connect_error ) {
			return "Error: Failed to connect to SQL";
		}
		
		$sql  = "UPDATE UserAccounts SET Email=? WHERE PrincipalID=?";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			die("Error: Failed to prepare SQL");
		
		$stmt->bind_param( "ss", $emailAddress, $userID );
		
		$worked = $stmt->execute();
		
		if($worked === FALSE)
			return "Error: MySQL Error!";
		else return TRUE;
	}
	
	
	function getEmailAddress( $userID )
	{
		include_once "includes/config.php";
		
		// Create connection
		$conn = new mysqli( SQLServerName, SQLUserName, SQLPassword, SQLDatabase );

		// Check connection
		if ( $conn->connect_error ) {
			die;
		}

		$sql  = "SELECT Email FROM UserAccounts WHERE PrincipalID=? LIMIT 1";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			die;
		
		$stmt->bind_param( "s", $userID );
		$stmt->bind_result( $email );
			
		$stmt->execute();
		$fetch = $stmt->fetch();
		
		return $email;
	}
?>