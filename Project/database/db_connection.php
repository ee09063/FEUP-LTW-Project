<?php
	$db = new PDO("sqlite:database/project.db");
	
/*	Verifica o login e o acesso do utilizdor. retorna em json o userID ou um erro */
	function checkLogin($user,$password)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db -> prepare("SELECT id FROM users WHERE username=? AND password=?");	
		$stmt->execute(array($user,$password));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result == FALSE) // Se nao encontrar ou estiver vazio
		{	
			$jResult = array('error' => array('code'=>404,'reason'=>'Username or password invalid!'));
			return json_encode($jResult);
		}
		$jResult = array('login' => array('id' => $result['id']));
		return json_encode($jResult);
	}

/* Cria um registo para login novo*/ 
	function createLogin($user,$password,$name,$email)
	{
		/* verifica se user é valido é uma string de numeros e letras */
		$pattern = '/^[a-zA-Z0-9_]{1,}$/';
		if(!preg_match($pattern,$user))
		{
			$jResult = array('error' => array('code'=>400,'reason'=>'Username Invalid! Only pick numbers and letters, between 4-16 caracters'));
			return json_encode($jResult);
		}
		/* verifica se pass é valido é uma string de numeros e letras */
		if(!preg_match($pattern,$password))
		{
			$jResult = array('error' => array('code'=>400,'reason'=>'Password Invalid! Only pick numbers and letters, between 4-16 caracters'));
			return json_encode($jResult);
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
    		$jResult = array('error' => array('code'=>400,'reason'=>'Email is not in a valid format! Please pick something in the format email@host.com'));
			return json_encode($jResult);
		}		
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db -> prepare("SELECT * FROM users WHERE username=?");	
		$stmt->execute(array($user));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result === FALSE) // Se nao encontrar ou estiver vazio
		{	
			$stmt = $db -> prepare('INSERT INTO users VALUES (NULL,?,?,?,?)');	
			if(($stmt->execute(array($user,$password,$name,$email))))
			{
				$jResult = array('registo' => array('username' => $user));
				return json_encode($jResult);
			}
			else{
				$jResult = array('error' => array('code'=>400,'reason'=>'Erro na escrita na base de dados!'));
				return json_encode($jResult);
			}
		}
		else
		{
			$jResult = array('error' => array('code'=>400,'reason'=>'Username already exists!'));
			return json_encode($jResult);
		}
		
	}
	
	function getUserId($username)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
		$stmt->execute(array($username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result['id'];
	}
	
	function getUsername($userid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
		$stmt->execute(array($userid));
		$result = $stmt->fetch();
		return $result['username'];
	}

	function getUserPolls($userid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM polls WHERE owner = ?');
		$stmt->execute(array($userid));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	function getUserInfo($username)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
		$stmt->execute(array($username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
		
	}
	
	function getOwner($pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM polls WHERE id = ?');
		$stmt->execute(array($pollid));
		$result = $stmt->fetch();
		return $result['owner'];
	}
	
	function getPoll($pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM polls WHERE id = ?');
		$stmt->execute(array($pollid));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	
	function getPollQuestions($pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM questions WHERE poll = ?');
		$stmt->execute(array($pollid));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	function getChoices($questionid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM choices WHERE question = ?');
		$stmt->execute(array($questionid));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	function changeLockedStatus($pollid, $locked)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('UPDATE polls SET locked=? WHERE id=?');
		if($locked == 0) //it's unlocked, let's lock it
		{
			$stmt->execute(array(1, $pollid));
		}
		else if($locked == 1) //it's locked, let's unlock it
		{
			$stmt->execute(array(0, $pollid));
		}
	}
	
	function changePrivateStatus($pollid, $private)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('UPDATE polls SET privateStatus=? WHERE id=?');
		if($private == 0) //it's public, let's lock it
		{
			$stmt->execute(array(1, $pollid));
		}
		else if($private == 1) //it's private, let's unlock it
		{
			$stmt->execute(array(0, $pollid));
		}
	}
	
	function deletePoll($pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$questions = getPollQuestions($pollid);
		foreach($questions as $question)
		{
			$choices = getChoices($question['id']);
			foreach($choices as $choice)
			{
				$stmtc = $db->prepare('DELETE FROM choices WHERE question = ?');
				$stmtc->execute(array($question['id']));
			}
			$stmtq = $db->prepare('DELETE FROM questions WHERE poll = ?');
			$stmtq->execute(array($pollid));
		}
		
		$stmt = $db->prepare('DELETE FROM polls WHERE id = ?');
		$stmt->execute(array($pollid));
	}
	
	function addPoll($userid, $title, $image, $des, $privacy)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db -> prepare('INSERT INTO polls VALUES (NULL,?,?,?,?,?,?)');
		$stmt->execute(array($title, $image, $des, $privacy, $userid, 0));
		if($stmt) //sucess
		{
			$row = $db->prepare('SELECT * FROM polls ORDER BY id DESC LIMIT 1');
			$row->execute();
			$result = $row->fetch(PDO::FETCH_ASSOC);
			if($result)
			{
				return $result['id'];
			}
		}
		else 
		{	
			echo "ERROR";
		}
	}
	
	function addQuestion($title, $pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db -> prepare('INSERT INTO questions VALUES (NULL, ? , 0, ?)');
		$stmt->execute(array($title, $pollid));
		if($stmt) //sucess
		{
			$row = $db->prepare('SELECT * FROM questions ORDER BY id DESC LIMIT 1');
			$row->execute();
			$result = $row->fetch(PDO::FETCH_ASSOC);
			if($result)
			{
				return $result['id'];
			}
		}
		else 
		{	
			echo "ERROR";
		}
	}

	function addChoice($title, $questionid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('INSERT INTO choices VALUES (NULL, ? , 0, ?)');
		$stmt->execute(array($title, $questionid));
		if($stmt) //sucess
		{
		}
		else 
		{	
			echo "ERROR";
		}
	}
	
	function alreadyAnswered($userid, $pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM answered WHERE userID=? AND poll=?');
		$stmt->execute(array($userid, $pollid));
		$result = $stmt->fetch();
		if($result === FALSE)
			return -1;
		else
			return 0;
	}

	function updateUserAnswered($userid, $pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		//update user answered poll
		$stmt = $db->prepare('INSERT INTO answered VALUES (?, ?)');
		$stmt->execute(array($userid,$pollid));
	}
	
	function updateAnswer($questionid, $choiceid)
	{
		$db = new PDO("sqlite:database/project.db");
		//update question
		$stmt2 = $db->prepare('UPDATE questions SET timesAnswered=timesAnswered+1 WHERE id=?');
		$stmt2->execute(array($questionid));
		
		//update choice
		$stmt3 = $db->prepare('UPDATE choices SET timesAnswered=timesAnswered+1 WHERE id=?');
		$stmt3->execute(array($choiceid));
	}
	
	function matchTitle($title) /*ALL NON PRIVATE POLLS*/
	{
		$db = new PDO("sqlite:database/project.db");
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $db->prepare("SELECT * FROM polls WHERE upper(title) LIKE upper(?) AND privateStatus=?");
		$stmt->execute(array("$title%",0));
		
		$polls = $stmt->fetchAll();
		
		return $polls;
	}
	
	
	function matchTitleAndId($title, $userid)
	{
		$db = new PDO("sqlite:database/project.db");
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $db->prepare("SELECT * FROM polls WHERE upper(title) LIKE upper(?) AND owner = ?");
		$stmt->execute(array("$title%", $userid));
		
		$polls = $stmt->fetchAll();
		
		return $polls;
	}
	
	function matchTitleAndIdAndAnswer($title, $userid)
	{
		$db = new PDO("sqlite:database/project.db");
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $db->prepare("SELECT * FROM polls INNER JOIN answered ON polls.id=answered.poll WHERE upper(polls.title) LIKE upper(?) AND answered.userID = ?");
		$stmt->execute(array("$title%", $userid));
		
		$polls = $stmt->fetchAll();
		
		return $polls;
	}
	
	function getVotes($pollid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT timesAnswered FROM questions WHERE poll=? LIMIT 1');
		$stmt->execute(array($pollid));
		$result = $stmt->fetch();
		if($result === FALSE)
			return -1;
		else
			return $result[0];
	}
	
	function get10Polls() /*POPULATE THE SEARCH ALL POLLS AREA*/
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM polls WHERE privateStatus = ? ORDER BY id DESC LIMIT 10');
		$stmt->execute(array(0));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($result === FALSE)
			return -1;
		else
			return $result;
	}
	
	function get10PollsAnswered($userid)
	{
		$db = new PDO("sqlite:database/project.db");
		$stmt = $db->prepare('SELECT * FROM polls, answered WHERE answered.userID = ? AND polls.id = answered.poll ORDER BY polls.id DESC LIMIT 10');
		$stmt->execute(array($userid));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($result === FALSE)
			return -1;
		else
			return $result;
	}
?>











































