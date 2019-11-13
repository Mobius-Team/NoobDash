<?php
	include_once "useful.php";
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		if(isset($_POST['submit'], $_POST['id']) && is_numeric($_POST['id']))
		{
			$id = $_POST['id'];
			switch( $_POST['submit'] ) 
			{
				case "Download Image":
				{
					$result = getAbuseReportImage( $id );
					if( $result === FALSE ) {
						echo "<script type='text/javascript'>alert('Failed to download image!');</script>";
					}
					else
					{
						header("Content-Length: " . strlen($result));
						header("Content-Type: application/octet-stream");
						header("Content-Transfer-Encoding: Binary"); 
						header("Content-disposition: attachment; filename=\"" . $id . ".jp2" . "\"");
						echo $result;
					}
					break;
				}
				case "Delete":
				{
					// Fake failure and redirect
					echo "<script type='text/javascript'>
						alert('Failed to delete abuse report!');
						window.location.href='/reports/view/" . $id . "';
					</script>";
					break;
				}
				default:
					break;
			}
		}
	}
?>