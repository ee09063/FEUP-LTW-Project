<?php 
	session_set_cookie_params(0);
	session_start();
	include_once('database/db_connection.php');
	
	$username = $_SESSION['user_id'];
	$userid = getUserId($username);
	
	if(isset($_POST['submit_val']))
	{
		updateUserAnswered($userid, $_POST['pollid']);
		$questions = getPollQuestions($_POST['pollid']);
		foreach($questions as $question)
		{
			$choice_id = $_POST['choice_'.$question['id']];
			updateAnswer($question['id'], $choice_id);
		}
		header("Location: poll_item.php?id=".$_POST['pollid']);
	}
	else
	{
		if(isset($_GET['id']))
		{
			$pollid = $_GET['id'];
			$poll = getPoll($pollid);
			$questions = getPollQuestions($pollid);
		}
		?>
		<html>
			<head>
				<title><?php echo $poll['title']; ?></title>
				<meta charset="UTF-8">
				<link rel="stylesheet" href="styles/pollAnswer.css">
			</head>
			<body>
				<?php include_once('templates/control_panel.php'); ?>
				<div id="poll">
					<h1 id="title"><?php echo $poll['title']?></h1>
					<img class="center" src=<?php echo $poll['imageurl']; ?> alt = "Poll Image" style="width:304px; height:228px">
					<p id="description"><?php echo $poll['description']; ?></p>
					<form id="poll_answer" action="poll_answer.php" method="post">
						<input type="hidden" name="pollid" value=<?php echo $pollid; ?>>
						<div id="questions">
							<?php foreach($questions as $question)
							{?>
								<fieldset class="questionField">
								<legend align="center" class="questionTitle"><?php echo $question['title']; ?></legend>
								<input type="hidden" name="questionid" value=<?php echo $question['id']?>>
								<div class="choices">
								<?php 
									$choices = getChoices($question['id']);
									foreach($choices as $choice) 
									{ ?>
										<p class="choice_item">
										<input type="radio" name="choice_<?php echo $question['id'];?>" value=<?php echo $choice['id']?> required><?php echo $choice['title']?></input>
										</p>
									<?php
									} ?>
								</div>
								</fieldset>
								<?php
								} ?>
						</div>
					<input type="submit" value="Submit" name="submit_val">
					</form>
				</div>
			</body>
		</html>
		<?php 
	} ?>
	