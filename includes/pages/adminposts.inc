		<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.php">Home</a></li>
				<li><a href="admin.php"> &raquo; Admincenter</a></li>
				<li><a href="admin.php?page=forum"> &raquo; Forum</a></li>
				<li class="current">&raquo; Topic</li>

			</ul>
			<div class="panel">
				<ul>
					<li><a href="admin.php">&raquo; Dashboard</a></li>
					<li><a href="admin.php?page=adminslist">&raquo; Admins</a></li>
					<li><a href="admin.php?page=banslist">&raquo; Bans</a></li>
					<li>&raquo; Forum</li>
					<li><a href="admin.php?page=userslist">&raquo; Users</a></li>
				</ul>
			</div>
			<div class="panel" style="width: 700px">
				<h1>Topic: </h1><?php echo $topic['name']; ?>
					<?php echo displayPosts($_GET['topic']); ?>
					<div class="post_buttons">
						<a href="admin.php?page=forum&action=newPost&topic=<?php echo $_GET['topic']; ?>"  class="small button">Answer</a>
					</div>
			</div>
		</div>
	</div>
</body>
</html>
