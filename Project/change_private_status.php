<?php 
	include_once('database/db_connection.php');
	
	$pollid =$_GET['id'];
	$private = $_GET['privateStatus'];

	changePrivateStatus($pollid, $private);
	
	header("Location: user_page.php");
?>