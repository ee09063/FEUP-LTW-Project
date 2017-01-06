<?php
	session_set_cookie_params(0);
	session_start();
	include_once('database/db_connection.php');
	
	$username = $_SESSION['user_id'];
	$userid = getUserId($username);
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $username?> Create Poll</title>
		<meta charset="UTF-8">
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="scripts/poll_create.js"></script>
		<link rel="stylesheet" href="styles/pollCreateStyle.css">
	</head>
	<body>
		<?php
			if(isset($_POST['submit_val']))
			{
				$poll_id = addPoll($userid, $_POST['poll_title'], $_POST['poll_image'], $_POST['poll_des'], $_POST['privacy']);
				for($i = 1; $i <= 20; $i++)
				{
					if(isset($_POST['question_title_'.$i]))
					{
						$question = $_POST['question_title_'.$i];
						$question_id = addQuestion($question, $poll_id);
						foreach($_POST['option'.$i] as $choice)
						{
							addChoice($choice, $question_id);
						}
					}
				}
				header("Location: user_page.php");
			}
			else if(!isset($_POST['submit_val']))
			{
					?>
					<?php include_once('templates/control_panel.php'); ?>
					<div id="createPollContainer">
					<form class="create_poll" action="poll_create.php" method="post">
						<p id="titlepar">
							<label for="poll_title">Title</label><br>
							<input id="titlebar" type="text" placeholder="Poll Title" name="poll_title" required><br>
						</p>
						<p id="imagepar">
							<label for="poll_image">Image URL</label><br>
							<input id="imagebar" type="text" placeholder="Image URL" name="poll_image" required><br>
						</p>
						<p id="descpar">
							<label for="poll_des">Description</label><br>
							<input id="descbar" type="text" placeholder="Description" name="poll_des" required><br>
						</p>
						<p>
							<fieldset id="privacyStatus"><legend>Private Status</legend>
							<input type="radio" name="privacy" value=1 checked>Private
							<input type="radio" name="privacy" value=0>Public
							</fieldset>
						</p>
						<div id="question_container">
							<p id="add_question"><a title="Add New Question" href="#"><span><img src="images/add_icon.jpg" style="width:30px; height:30px"></span></a></p>
						</div>
						<input type="submit" value="Submit" name="submit_val">
						</form>
					</div>
				<?php } ?>
	</body>
</html>