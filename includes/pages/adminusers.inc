		<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.php">Home</a></li>
				<li class="current"> &raquo; Admincenter</li>

			</ul>
			<div class="panel">
				<ul>
					<li>&raquo; Userlist</li>
					<li><a href="#">&raquo; Adminlist</a></li>
					<li><a href="#">&raquo; Banlist</a></li>
				</ul>
			</div>
			<div class="panel" style="width: 700px">
				<h1>Userlist:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>ID</td><td>Name</td><td>SteamID</td><td>Country</td><td>Actions</td><td>&nbsp;</tr>	
						</thead>
						<tbody>
							<?php echo $userlist; ?>
						</tbody>
					</table>
					<img src="theme/images/bullet_right.png" style="float:right;" /><img src="theme/images/bullet_left.png" style="float:right;" />
			</div>
		</div>
	</div>
</body>
</html>
