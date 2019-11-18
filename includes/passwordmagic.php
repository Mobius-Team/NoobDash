<?php
	
	function changeAccountPassword( $agent, $current, $new )
	{
		include_once "config.php";
		
		// Create connection
		$conn = new mysqli(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);

		// Check connection
		if ( $conn->connect_error ) {
			return "Failed to connect to SQL";
		}

		$sql  = "SELECT passwordSalt, passwordHash FROM auth WHERE UUID=? LIMIT 1";
		$stmt = $conn->stmt_init();

		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
		
		$stmt->bind_param( "s", $agent );
		$stmt->bind_result( $salt, $hash );
			
		$stmt->execute();
		$fetch = $stmt->fetch();

		if( !empty( $fetch ) )
		{
			$firstMD5 = md5( $current );
			$secondMD5 = md5( $firstMD5 . ":" . $salt );

			if( $secondMD5 === $hash ) {
				$new_pass = md5( $new );
				$new_salt = md5( rand() );
				$new_hash = md5( $new_pass . ":" . $new_salt );
				
				$sql  = "UPDATE auth SET passwordSalt=?, passwordHash=? WHERE UUID=?";
				$stmt = $conn->stmt_init();

				if( !$stmt->prepare( $sql ) )
					die("Error: Failed to prepare SQL");
				
				$stmt->bind_param( "sss", $new_salt, $new_hash, $agent );
				
				$worked = $stmt->execute();
				
				if($worked === FALSE)
					return "Error: MySQL Error!";
				else return TRUE;
			}
			else {
				return "Password is incorrect!";		
			}
		}
	}

?>