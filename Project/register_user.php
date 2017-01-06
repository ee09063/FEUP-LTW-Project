<?php
	session_set_cookie_params(0);
	session_start();
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		try
		{	
			require_once('database/db_connection.php');
			$request = json_decode(createLogin($_POST['username'],sha1($_POST['password']),$_POST['nome'],$_POST['email']),TRUE);
			//print_r($request);
			?>
				<p id="errormsg"><?php print_r($request['error']['reason']) ?></p>
			<?php
			if(isset($request['registo']))
			{
				$_SESSION['user_id'] = $_POST['username'];
				header("location:user_page.php");
			}
			else if(isset($request['error']))
				{
					$msg = $request['error']['reason'];
				}
				else{
					$msg = "Erro Desconhecido!";
				}
		}
		catch(Exception $e)
		{
			$msg = "Cannot connect to database!";
			echo("Warning: Can´t connect to database!");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/registerStyle.css">
	</head>
	<body>
		<div id="mainframe">
			<form class="login" action="register_user.php"  method="post">
			<p>
				<fieldset><legend align="center">Register</legend>
				<label for="username">Username</label><br>
				<input type="text" pattern="[a-zA-Z0-9]{4,16}" placeholder="Username pretendido" name="username" required><br>				
    		</p>
    		<p>
      			<label for="password">Password</label><br>
      			<input type="password" pattern="[a-zA-Z0-9]{4,16}" name="password" id="password" placeholder="Escolha uma senha" required>
    		</p>
			<p>
			<label for="name">Name</label><br>
			<input type="text" pattern="^([ \u00c0-\u01ffa-zA-Z'\-])+$" name="nome">
    		</p>
			<p>
			<label for="email">Email</label><br>
			<input type="email" pattern="^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$" name="email">
    		</p>
			</fieldset>
			<p class="login-submit">
      			<button type="submit" class="login-button" >Register</button>
    		</p>
  			</form>
		</div>
	</body>
</html>