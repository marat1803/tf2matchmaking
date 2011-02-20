<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.html">Home</a></li>
				<li class="current"> &raquo; Admincenter</li>

			</ul>
			<div class="panel">
				<ul>
					<li><a href="#">&raquo; Userlist</a></li>
					<li>&raquo; Ban user</li>
					<li><a href="#">&raquo; Banlist</a></li>
				</ul>
			</div>
			<div class="panel" style="width: 700px">
				<h1>Ban user:</h1><?php if (!$post) { ?>
				<form method="post" action="admin.php?page=banuser">
					<input type="hidden" value="<?php echo $_GET['id']; ?>" name="user" />
					<label>User</label><?php $player = player($_GET['id']); echo $player['nickname']; ?>
					<label>Lobby</label><?php echo selectLastLobbies($_GET['id']); ?>
					<label>Reason</label>
					<select style="width: 135px;" name="reason">
						<option value="noshow">No Show</option>
						<option value="noshowvoice">No Show Voice</option>
						<option value="ragequit">Rage Quit</option>
						<option value="racism">Racism</option>
						<option value="custom">Custom</option>
					</select>
					<label>Amount</label><input type="text" name="amount" />
					<label>Comment</label><textarea name="comment" rows="3" cols="20" style="float: left;"></textarea>
					<input type="submit" value="Submit" class="button small" style="clear: left;float: left;" />
				</form><?php } else echo $message; ?>
			</div>
		</div>
	</div>
</body>
</html>