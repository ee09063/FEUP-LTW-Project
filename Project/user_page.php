<?php
	session_set_cookie_params(0);
	session_start();
	include_once('database/db_connection.php');
	
	$username = $_SESSION['user_id'];
	$userid = getUserId($username);
	$_SESSION['id'] = $userid;
?>
<html>
	<head>
		<title><?php echo $username; ?>'s User Page</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/userPageStyle.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript">var userid = "<?= $userid ?>";</script>
		<script type="text/javascript" src="scripts/user_page.js"></script>	
	</head>
	<body>
		<?php include_once('templates/control_panel.php'); ?>
		<div id="userBars">
			<?php include_once('templates/user_polls_panel.php'); ?>
			<?php include_once('templates/search_answered_polls.html'); ?>
			<?php include_once('templates/search_all_polls_panel.html'); ?>
		</div>
	</body>
	<footer>
	</footer>
</html>