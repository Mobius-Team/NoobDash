<?php
	include_once "config.php";
	
	function changeRSASettings( $agent, $key, $disable )
	{
		$rsaData = getRSAData( $agent );
		
		if( $rsaData["disable"] === "1" )
		{
			return "Error: Cannot change setting if password login is disabled!";
		}
		
		if( $rsaData["disable"] === "0" && ( empty( $rsaData["key"] ) || $rsaData["key"] != $key ) )
		{
			if( !empty( $key ) && $disable == 1 )
			{
				return "Error: Cannot apply a key and disable password login at the same time!";
			}
		}
		
		// Create connection
		$conn = new mysqli( SQLServerName, SQLUserName, SQLPassword, SQLDatabase );

		// Check connection
		if ( $conn->connect_error ) {
			return "Error: Failed to connect to SQL";
		}
		
		$sql  = "UPDATE auth SET rsaOnly=?, rsaKey=? WHERE UUID=?";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			die("Error: Failed to prepare SQL");
		
		$stmt->bind_param( "iss", $disable, $key, $agent );
		
		$worked = $stmt->execute();
		
		if($worked === FALSE)
			return "Error: MySQL Error!";
		else return TRUE;
	}
	
	function getRSAData( $userID )
	{
		// Create connection
		$conn = new mysqli( SQLServerName, SQLUserName, SQLPassword, SQLDatabase );

		// Check connection
		if ( $conn->connect_error ) {
			die;
		}

		$sql  = "SELECT rsaOnly, rsaKey FROM auth WHERE UUID=? LIMIT 1";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			die("failed to prepare");
		
		$stmt->bind_param( "s", $userID );
		$stmt->bind_result( $rsaOnly, $rsaKey );
			
		$stmt->execute();
		$fetch = $stmt->fetch();
		
		$data = array();
		$data["key"] = $rsaKey;
		$data["disable"] = $rsaOnly;
		
		return $data;
	}
?>