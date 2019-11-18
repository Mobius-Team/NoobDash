<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	</head>
	<body>
		
<?php
	include_once "includes/config.php";
	include_once "includes/useful.php";
	
	$allowed = FALSE;
	
	session_start();
	
	if ( isset( $_SESSION['user_id'] ) ) {
		if ( isset( $_SESSION['user_level'] ) )  {
			if( $_SESSION['user_level'] > 0 ) {
				$allowed = TRUE;
			}
		}
	}
	
	if( !$allowed ) {
		header("Location: " . WebsiteURL);
		exit();
	}
	
	header('Content-Type: text/html; charset=utf-8');
	
	
	function parse_summary( $summary )
	{
		$test = explode('"', $summary, 2);
		
		$summary_text = trim( $test[1], '"' );
		
		$data = array();
		$data["summary"] = $summary_text;
		return $data;
	}
	
	echo '<div class="top-right">Welcome, <a href="/account">' . $_SESSION['user_name'] . '</a>&nbsp;&nbsp;&nbsp;
			<a href="includes/logout.php">Logout</a>
		</div>';
	
	$path = $_SERVER['REQUEST_URI'];
	
	$con = mysqli_connect(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);
	$con->set_charset('utf8mb4');
	
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit();
	}
	
	if ($path == "/reports")
	{
		echo '<div><a href="/">Back</a></div>';
		$result = mysqli_query($con,"SELECT * FROM AbuseReports ORDER BY ReportID DESC");

		echo "<table border='1' align='center'>
		<tr>
		<th>ID</th>
		<th>Sender</th>
		<th>Abuser</th>
		<th>Region</th>
		<th>Category</th>
		<th>Time</th>
		</tr>";

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td><a href='reports/view/" . $row['ReportID'] . "'>" . $row['ReportID'] . "</a></td>";
			echo "<td>" . $row['SenderName'] . "</td>";
			echo "<td>" . $row['AbuserName'] . "</td>";
			echo "<td>" . $row['AbuseRegionName'] . "</td>";
			echo "<td>" . category_to_name($row['Category']) . "</td>";
			echo "<td>" . gmdate("Y-m-d H:i:s", $row['Time'] ). "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		echo '<div><a href="/reports">Back</a></div><br>';
		
		$parse = explode("/", $path);
		if( $parse[2] == "view" && is_numeric( $parse[3] ))
		{
			echo "VIEW REPORT " . $parse[3] . "<br><br>";
			
			$sql = "SELECT AbuserName, SenderName, Category, Summary, Details, Time, Version, AbuseRegionName FROM AbuseReports WHERE ReportID = ?";
			
			$stmt = $con->stmt_init();
			
			if( !$stmt->prepare( $sql ) )
				die("failed to prepare");
				
			$stmt->bind_param( "i", $id );
			$stmt->bind_result( $abuser_name, $reporter_name, $category, $summary, $details, $time, $version, $region_name );
			
			$id = (int)$parse[3];
			
			$stmt->execute();
			$fetch = $stmt->fetch();
			
			if (!$fetch) {
				printf("Error: %s\n", mysqli_error($con));
			}
			else
			{
				echo "Report sent by: " . $reporter_name;
				echo "<br>Report sent about: " . $abuser_name;

				echo "<br><br>Region: " . $region_name;
				echo "<br>Time: " . gmdate("Y-m-d H:i:s", $time );
				echo "<br><br>Category: " . category_to_name( $category );
				
				$summary_parse = parse_summary( $summary );
				
				echo "<br><br>Summary: " . htmlspecialchars( $summary_parse["summary"] );
				echo "<br><br>Details:<br>" . nl2br( htmlspecialchars( $details ) );
				echo "<br><br>Version: " . $version;
				echo "<br><br>";
				
				echo '<div class="test_box">
					<form method="post" action="/includes/reportmagic.php">
						<input type="hidden" name="id" value="' . $id . '">
						<input name="submit" type="submit" value="Download Image" />
						<input name="submit" type="submit" value="Mark as Read" disabled />
						<input name="submit" type="submit" value="Respond" disabled />
						<input name="submit" type="submit" value="Delete" />
					</form>
				</div>';
			}
		}
	}
	
	mysqli_close($con);
?>
	</body>
	<footer class="footer">Copyright (c) 2019, Mobius Team<div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>