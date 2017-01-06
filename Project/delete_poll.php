<?php
	session_start();
	include_once('database/db_connection.php');
	
	$pollid = $_GET['id'];
	$userid = getOwner($pollid);
	$username = getUsername($userid);

	if($username == $_SESSION['user_id'])
	{
		deletePoll($pollid);
	}
	header("Location: user_page.php");
?>