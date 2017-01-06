<?php
	session_set_cookie_params(0);
	session_start();
	if(isset($_SESSION['user_id']))
	{
		header("location:user_page.php");
	}
	else
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			try 
			{
				require_once('database/db_connection.php');
				$request = json_decode(checkLogin($_POST['username'],sha1($_POST['password'])),TRUE);
				?>
				<p><?php print_r($request['error']['reason']) ?></p>
				<?php
				if(isset($request['login']))
				{
					$_SESSION['user_id'] = $_POST['username'];	
					header("location:user_page.php");
				}
				else if(isset($request['error']))
				{
					$msg = $request['error']['reason'];
					session_destroy();
				}
				else
				{
					$msg = "Username or password invalid!";
					session_destroy();
				}

			}
			catch(Exception $e)
			{
				$msg = "Cannot connect to database.";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/loginStyle.css">
	</head>
	<body>
		<img class="center" align="middle" src="images/poll.jpg" alt="Poll" style="width:304px;height:228px">
		<h1>LTW</h1>
		<div id="loginDiv">
			<form action="index.php" method="post">
			<fieldset><legend align="center">Login</legend>
			<p>
				<label for="username">Username</label><br>
				<input type="text" name="username">
			</p>
			<p>
				<label for="password">Password</label><br>
				<input type="password" name="password">
			</p>
			</fieldset>
			<input type="submit" value="Login"/>
			</form>
			<form action="register_user.php">
				<input type="submit" value="Register"/>
			</form>
		</div>
		<footer>
		</footer>
	</body\>
</html>