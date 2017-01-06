<?php 
	include_once('database/db_connection.php');
	
	$pollid =$_GET['id'];
	$locked = $_GET['lockedStatus'];

	changeLockedStatus($pollid, $locked);
	
	header("Location: user_page.php");
?>