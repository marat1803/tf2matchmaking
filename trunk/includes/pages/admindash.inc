		<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.php">Home</a></li>
				<li class="current"> &raquo; Admincenter</li>

			</ul>
			<div class="panel">
				<ul>
					<li>&raquo; Dashboard</li>
					<li><a href="admin.php?page=adminslist">&raquo; Admins</a></li>
					<li><a href="admin.php?page=banslist">&raquo; Bans</a></li>
					<li><a href="admin.php?page=forum">&raquo; Forum</a></li>
					<li><a href="admin.php?page=userslist">&raquo; Users</a></li>
				</ul>
			</div>
			<ul class="recentlobby_panel" style="width: 200px; float: left;  margin-left: 25px">
				<li><span>Powerlobby<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_granary.jpg"></li>
				<li><span>Superlobby<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_granary.jpg"></li>
			</ul>
			<div class="panel" style="width: 490px">
				<h1>New Posts:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>&nbsp;</td><td>Topic</td><td>&nbsp;</td><td>User</td><td>Date</td></tr>	
						</thead>
						<tbody>
							<?php echo newPosts(); ?>
						</tbody>
					</table>
			</div>
			<div style="clear: both;"></div>
			<div class="panel" style="width: 400px; margin-left: 136px;">
				<h1>Server Stats:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>&nbsp;</td><td>Name</td><td>Status</td></tr>	
						</thead>
						<tbody>
							<?php echo serversList(); ?>
						</tbody>
					</table>
			</div>
			<div class="panel" style="width: 300px;">
				<h1>Site Stats:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>&nbsp;</td><td>Stats</td><td>&nbsp;</td><td>&nbsp;</td></tr>	
						</thead>
						<tbody>
							<?php echo siteStats(); ?>
						</tbody>
					</table>
			</div>
			<div style="clear: both;"></div>
			<div class="panel" style="width: 450px; margin-left: 136px;">
				<h1>New Reports:</h1>
					<table style="width: 100%">
						<thead>
							<tr><td>&nbsp;</td><td>Name</td><td>Lobby</td><td>Subject</td><td>&nbsp;</td></tr>	
						</thead>
						<tbody>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
							<tr><td><img src="theme/images/bullet_green.png"></td><td>Nightbox</td><td>Testlobby</td><td>Left Lobby early</td><td><a href="#ban"><img src="theme/images/bullet_magnify.png"></a></td></tr>
						</tbody>
					</table>
			</div>
			<div class="panel" style="width: 250px">
				<h1>New Users:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>&nbsp;</td><td>Name</td><td>ID</td><td>Actions</td></tr>	
						</thead>
						<tbody>
							<?php echo newUsers(); ?>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</body>
</html>
