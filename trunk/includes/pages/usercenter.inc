<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.php">Home</a></li>
				<li><a href="profile.php"> &raquo; Profile</a></li>
				<li class="current"> &raquo; Control Center</li>
			</ul>
		<form method="post" action="usercenter.php">
			<div class="avatar_panel">
				<img class="avatar_big" src="<?php echo APIGet($user->steamid,'avatar'); ?>">
			</div>
			<div class="left" style="width: 300px; float: left;">
				<div class="panel" style="width: 300px;">
					<h1>Edit Info:</h1>
					<label>Nickname:</label>
					<input type="text" value="<?php echo $user->nickname; ?>" name="nickname"/>
					<label>Email:</label>
					<input type="text" value="<?php echo $user->email; ?>" name="email"/>
					<label>Country:</label>
					<select type="text" name="loc">
					<?php echo $user->countrySelect(); ?>
					</select>
				</div>
				<div class="panel" style="width: 300px;">
					<h1>Settings:</h1>
					<label>Dummy:</label>
					<input type="checkbox" value="dummy" name="dummy"/>
					<label>Newsletter:</label>
					<input type="checkbox" value="newsletter" name="newsletter"/>
				</div>
			</div>
			<div class="right" style="float: right; width: 300px;">
				<div class="panel" style="width: 300px; float: right;">
					<h1>Steam<small><a href="#update_steam"><img src="theme/images/arrow_refresh_small.png" style="height: 12px;" /></a></small></h1>
					<dl>
						<dt>Name:</dt><dd><?php echo APIGet($user->steamid,'personaname'); ?></dd>
						<dt>STEAM_ID:</dt><dd><?php echo GetAuthID($user->steamid); ?></dd>
						<dt>Profile:</dt><dd><a href="<?php echo APIGet($user->steamid,'profileurl'); ?>"><?php echo str_replace('http://steamcommunity.com', '', APIGet($user->steamid,'profileurl')); ?></a></dd>
					</dl>
				</div>
				<div class="panel" style="width: 300px; float: right;">
					<h1>ETF2L<small><a href="#update_etf2l"> <img src="theme/images/arrow_refresh_small.png" style="height: 12px;" /></a></small></h1>
					<dl>
						<dt>Name:</dt><dd><?php echo etf2l($user->steamid, 'displayname'); ?></dd>
						<dt>User ID:</dt><dd><?php echo etf2l($user->steamid, 'id'); ?></dd>
						<dt>Profile:</dt><dd><a href="<?php echo etf2l($user->steamid, 'url'); ?>"><?php echo str_replace('http://etf2l.org/forum','', etf2l($user->steamid, 'url')); ?></a></dd>
					</dl>
				</div>
			</div>
			<div class="profile_panel" style="float: left; clear: left; margin: 0 20px 10px;">
				<dl>
					<dt>Mainclass:</dt><dd><?php echo displayClass($user->mainclass); ?><img class="class_icon" src="theme/images/class/<?php echo player_class($user->mainclass); ?>.png" height="14"></dd>
					<dt>Skilllevel:</dt><dd><?php echo $user->division; ?></dd>
					<dt>Rating:</dt><dd><?php echo $user->rating; ?></dd>
				</dl>
				<input type="submit" class="button small" value="Edit Profile!" />
			</div>
			<div class="friends_panel" style="width: 450px; margin-left: 30px;">
				<h1>Friends</h1>
				<ul>
					<?php echo getfriends($user->id,'remove'); ?>
				</ul>
			</div>
			<div class="team_panel">
				<h1>Team<small>(from ETF2L)</small></h1>
				<ul>
					<li>
						<img src="http://media.steampowered.com/steamcommunity/public/images/avatars/4b/4be5d08ac4dde632773f3b9f28663cae74d02169.jpg">
						<span class="user_name">The Good Guys!</span><input type="radio" name="teamid" value="teamid1" checked="checked" />
						<span class="user_steamid"><a href="http://good.hobbygaming.de/">good.hobbygaming.de</a></span>
					</li>
					<li>
						<img src="http://media.steampowered.com/steamcommunity/public/images/avatars/4b/4be5d08ac4dde632773f3b9f28663cae74d02169.jpg">
						<span class="user_name">The Bad Guys!</span><input type="radio" name="teamid" value="teamid2" />
						<span class="user_steamid"><a href="http://good.hobbygaming.de/">good.hobbygaming.de</a></span>
					</li>
				</ul>
			</div>
		</form>
		</div>
	</div>
</body>
</html>
