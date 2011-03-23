		<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.php">Home</a></li>
				<li><a href="admin.php"> &raquo; Admincenter</a></li>
				<li class="current"> &raquo; Bans List</li>

			</ul>
			<div class="panel">
				<ul>
					<li><a href="admin.php">&raquo; Dashboard</a></li>
					<li><a href="admin.php?page=adminslist">&raquo; Admins</a></li>
					<li>&raquo; Bans</li>
					<li><a href="admin.php?page=forum">&raquo; Forum</a></li>
					<li><a href="admin.php?page=userslist">&raquo; Users</a></li>
				</ul>
			</div>
			<div class="panel" style="width: 700px">
				<h1>Userlist:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>ID</td><td>Player</td><td>Admin</td><td>Reason</td><td>Amount</td><td>Actions</td><td>&nbsp;</td></tr>	
						</thead>
						<tbody>
							<?php echo bansList(); ?>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</body>
</html>
