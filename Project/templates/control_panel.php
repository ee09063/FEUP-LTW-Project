<div id="controlPanel">
	<h2 id="controlTitle">Control Panel</h2>
	<ul id="menu">
		<li><a title= "Create New Poll" id="poll_create_button" href="poll_create.php">AAAA</a></li>
		<li><a title="<?php echo $_SESSION['user_id']; ?>'s Personal Page"id="profile_button" href="user_page.php">AAAA</a></li>
		<li><a title="Logout" id="logout_button" href="logout.php">AAAA</a></li>
	</ul>
	<span>
		<h2><?php echo "Welcome, "; echo $_SESSION['user_id']; ?></h2>
	</span>
</div>