<?php
	function getAbuseReportImage( $reportID )
	{
		include_once "config.php";
		$con = mysqli_connect(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);
		$con->set_charset('utf8mb4');
		
		// Check connection
		if (mysqli_connect_errno())
			return FALSE;
		
		$sql = "SELECT ImageData FROM AbuseReports WHERE ReportID = ?";
		
		$stmt = $con->stmt_init();
		
		if( !$stmt->prepare( $sql ) )
			return FALSE;
			
		$stmt->bind_param( "i", $reportID );
		$stmt->bind_result( $image_data );
		
		$stmt->execute();
		$fetch = $stmt->fetch();
		
		if (!$fetch) {
			return FALSE;
		}
		
		return $image_data;
	}
	
	function category_to_name($category)
	{
		if($category == "31")
			return "Age > Age play";
		else if($category == "35")
			return "Assault > Shooting, pushing, or shoving another Resident in a Safe Area";
		else if($category == "39")
			return "Disclosure > Real world information";
		else if($category == "43")
			return "Disturbing the peace > Excessive scripted objects";
		else if($category == "44")
			return "Disturbing the peace > Object littering";
		else if($category == "45")
			return "Disturbing the peace > Repetitive spam";
		else if($category == "50")
			return "Fraud > L$ or USD $";
		else if($category == "55")
			return "Harassment > Targeted behavior intended to disrupt";
		else if($category == "57")
			return "Indecency > Broadly offensive content or conduct";
		else if($category == "59")
			return "Indecency > Inappropriate avatar name";
		else if($category == "60")
			return "Indecency > Inappropriate content or conduct for Region Rating";
		else if($category == "61")
			return "Intolerance";
		else if($category == "63")
			return "Land > Encroachment > Objects or textures";
		else if($category == "67")
			return "Skill Gaming Policy Violation";
		else return "Unknown";
	} 
?>