<?php 
	include_once('database/db_connection.php');
	session_start();
	$username = $_SESSION['user_id'];
	$userid = getUserId($username);
	
	function curPageURL() {
	 $pageURL = 'http';
	 if(isset($_SERVER["HTTPS"]))
	 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	
	if(isset($_GET['id']))
	{
		$pollid = $_GET['id'];
		$poll = getPoll($pollid);
		$questions = getPollQuestions($pollid);
		$ownerUsername = getUsername($poll['owner']);
	
		if(alreadyAnswered($userid,$poll['id']) > -1 || $poll['locked'] == 1)
		{
			?>
			<html>
				<head>
					<title>Results</title>
					<meta charset="UTF-8">
					<link rel="stylesheet" href="styles/pollResult.css">
					<!--Load the AJAX API-->
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<?php include_once('scripts/chart.php'); ?>
				</head>
				<body>
					<script>
				      window.fbAsyncInit = function() {
				        FB.init({
				          appId      : 'your-app-id',
				          xfbml      : true,
				          version    : 'v2.1'
				        });
				      };

				      (function(d, s, id){
				         var js, fjs = d.getElementsByTagName(s)[0];
				         if (d.getElementById(id)) {return;}
				         js = d.createElement(s); js.id = id;
				         js.src = "//connect.facebook.net/en_US/sdk.js";
				         fjs.parentNode.insertBefore(js, fjs);
				       }(document, 'script', 'facebook-jssdk'));
				    </script>
					<?php include_once('templates/control_panel.php'); ?>
					<div id="poll">
						<h1 id="title"><?php echo $poll['title']; ?></h1>
						<img class="center" src=<?php echo $poll['imageurl']; ?> alt = "Poll Image" style="width:304px; height:228px">
						<p id="description"><?php echo $poll['description']; ?></p>
						<div id="questions">
							<?php
								foreach($questions as $question)
								{
							?>
									<fieldset class="question_item">
										<legend align="center"><h2 id="questionTitle"><?php echo $question['title']; ?></h2></legend>
										<div class="choices">
										<?php 
											$choices = getChoices($question['id']);
											foreach($choices as $choice) {
										?>
										<p>
											<span class="choice_title"><?php echo $choice['title'];?></span>
											<span class="choice_total"><?php echo $choice['timesAnswered']; ?></span>
										</p>
										<?php } ?>
										</div>
										<p class="question_total">
											<?php 
											echo "Total: "; echo $question['timesAnswered'];
											?>
											<div class="chart" id="chart<?php echo $question['id']?>"></div>
										</p>
									</fieldset>
						  <?php } ?>
						</div>
						<span class="share">
							<div class="email-share-button"> <a href="mailto:?subject=I wanted you to vote on this poll&amp;body=Vote on this poll please! <? echo curPageURL(); ?>" title="Share by Email"><img src="http://png-2.findicons.com/files/icons/573/must_have/48/mail.png"/></a></div>
							<div class="fb-share-button" data-href="<? echo curPageURL(); ?>" data-layout="button_count"></div>
						</span>
					</div>
				</body>
			</html>
		<?php 
		}
		else
		{
			header("Location: poll_answer.php?id=".$_GET['id']);
		}
	}
?>