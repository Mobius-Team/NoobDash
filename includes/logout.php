<?php
	include_once "config.php";
	
	session_start();
	unset($_SESSION['user_id']);
	unset($_SESSION['user_level']);
	session_destroy();
	
	header("Location: " . WebsiteURL);
	exit();
?>