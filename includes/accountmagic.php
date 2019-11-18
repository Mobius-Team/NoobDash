<?php
	function createUser( $first_name, $last_name, $password, $email, &$info )
	{
		include_once "config.php";
		include_once "useful.php";
		include_once "inventorymagic.php";
		
		// Create connection
		$conn = new mysqli(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);

		// Check connection
		if ( $conn->connect_error ) {
			return "Failed to connect to SQL";
		}

		$sql  = "SELECT PrincipalID FROM UserAccounts WHERE FirstName=? AND LastName=? LIMIT 1";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
		
		$stmt->bind_param( "ss", $first_name, $last_name );
		$stmt->bind_result( $agentID );
			
		$stmt->execute();
		$fetch = $stmt->fetch();

		if( !empty( $fetch ) ) {
			return "Account already exists!";
		}
		
		$uuid = generateUUID();
		
		$scope_id = "00000000-0000-0000-0000-000000000000";
		
		$sql  = "INSERT INTO UserAccounts (PrincipalID, ScopeID, FirstName, LastName, Email, Created) VALUES (?,?,?,?,?,?)";
		
		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
			
		$time = time();
		
		$stmt->bind_param( "sssssi", $uuid, $scope_id, $first_name, $last_name, $email, $time );
		
		if( $stmt->execute() === FALSE )
			return "Failed to create account!";
		
		$sql  = "INSERT INTO auth (UUID, passwordHash, passwordSalt) VALUES (?,?,?)";
		
		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
			
		$password_salt = md5( rand() );
		$password_hash = md5( md5( $password ) . ":" . $password_salt );
		
		$stmt->bind_param( "sss", $uuid, $password_hash, $password_salt );
		
		if( $stmt->execute() === FALSE )
			return "Failed to auth!";
			
		if( createDefaultInventory( $uuid ) !== TRUE )
			return "Failed to create inventory!";
			
		$info = $uuid;
			
		return TRUE;
	}
?>