<?php
	function loginWithPassword( $first_name, $last_name, $password ) {
		
		include_once "config.php";
		
		// Create connection
		$conn = new mysqli(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);

		// Check connection
		if ( $conn->connect_error ) {
			return "Failed to connect to SQL";
		}

		$sql  = "SELECT PrincipalID, UserLevel, FirstName, LastName FROM UserAccounts WHERE FirstName=? AND LastName=? LIMIT 1";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
		
		$stmt->bind_param( "ss", $first_name, $last_name );
		$stmt->bind_result( $agentID, $userLevel, $firstName, $lastName );
			
		$stmt->execute();
		$fetch = $stmt->fetch();

		if( !empty( $fetch ) ) {
			$sql  = "SELECT passwordSalt, passwordHash FROM auth WHERE UUID=? LIMIT 1";
			$stmt = $conn->stmt_init();

			if( !$stmt->prepare( $sql ) )
				return "Failed to prepare SQL";
			
			$stmt->bind_param( "s", $agentID );
			$stmt->bind_result( $salt, $hash );
				
			$stmt->execute();
			$fetch = $stmt->fetch();

			if( !empty( $fetch ) )
			{
				$firstMD5 = md5( $password );
				$secondMD5 = md5( $firstMD5 . ":" . $salt );
				
				$user_name = $firstName;
				if( strtolower( $lastName ) !== "resident" )
				{
					$user_name = $firstName . " " . $lastName;
				}

				if( $secondMD5 === $hash ) {
					$_SESSION["user_id"] = $agentID;
					$_SESSION["user_level"] = (int)$userLevel;
					$_SESSION["user_name"] = $user_name;
					return TRUE;
				}
				else {
					return "Password is incorrect!";		
				}
			}
		}
		else {
			return "Account not found!";
		}
	}
?>