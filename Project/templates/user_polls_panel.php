<?php
	$result = getUserPolls($userid);
?>
<div id="userPolls">
	<fieldset id="myPolls" class="field_set">
		<legend align="center">
			<input id="searchUserPolls" name="userPolls" type="text" placeholder="My Polls">
		</legend>
		<div  id="pollList">
			<?php foreach($result as $poll){ ?>
				<p class="pollItem">
					<span title="Open Poll"><a class="poll_link" href="poll_item.php?id=<?php echo $poll['id']; ?>"> <?php echo $poll['title']; ?> </a></span>
					<span class="nVotes"><?php echo "Votes: ".getVotes($poll['id']); ?></span>
						<span title="Delete Poll">
							<a id="delete_button" href="delete_poll.php?id=<?php echo $poll['id']  ?>"
								onclick="return confirm('You are about to delete Poll <?php echo $poll['title']; ?>');">
							</a>
						</span>
						<?php if($poll['privateStatus'] == 1)
						{
							?><span title="Make Public"> <a id="public_button" href="change_private_status.php?id=<?php echo $poll['id']; ?>&privateStatus=1">Public Poll</a></span> <?php
						}
						else if($poll['privateStatus'] == 0)
						{ 
							?> <span title="Make Private"><a id="private_button" href="change_private_status.php?id=<?php echo $poll['id']; ?>&privateStatus=0">Private Poll</a></span> <?php
						} ?>
						<?php if($poll['locked'] == 1)
						{
							?><span title="Unlock Poll"><a id="unlock_button" href="change_locked_status.php?id=<?php echo $poll['id']; ?>&lockedStatus=1">Unlock Poll</a></span><?php
						}
						else if($poll['locked'] == 0)
						{ 
							?><span title="Lock Poll"><a id="lock_button" href="change_locked_status.php?id=<?php echo $poll['id']; ?>&lockedStatus=0">Lock Poll</a></span><?php
						}
						?>
				</p>
			<?php } ?>
		</div>
	</fieldset>
</div>

