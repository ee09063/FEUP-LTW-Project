<?php
	$title = $_GET['title'];
	
	if(isset($_GET['id']))
	{
		$userid = $_GET['id'];
	}

	include_once('database/db_connection.php');
	
	if(isset($_GET['answer'])) /*GET THE ANSWERED ONES*/
	{
		$polls = matchTitleAndIdAndAnswer($title, $userid);
	}
	else if(isset($_GET['id']))/*GET USER POLLS*/
	{
		$polls = matchTitleAndId($title, $userid);
	}
	else /*GET ALL POLLS*/
	{
		$polls = matchTitle($title);
	}
	
	echo json_encode($polls);	
?>
