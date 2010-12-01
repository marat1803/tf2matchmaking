<?php

require 'includes/header.php';

if(isset($_SESSION['steamid'])) {

$id = displayID($_SESSION['steamid']);

		
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>TF2 Matchmaking System</title>
	<link href="theme/style.css" rel="stylesheet" type="text/css" />
	<link href="theme/uniform.default.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="background_image"></div>
	<div id="wrapper">
		<div id="header">
			<a href="" id="logo">TF2 Matchmaking System</a>
		</div>
		<ul id="sidebar">
			<li class="play_now_button">Play Now!</li>
			<li id="lobby_filter">
				<ul id="lobbys_opened">
					<li>'.countLobbies(0).' open lobbies</li>
					<li>'.countLobbies(1).' lobbies in play</li>
				</ul>
				<form method="get" action="">
					<input type="checkbox" value="true" id="not_full"><label for="not_full">Not Full</label>
					<div class="clear"></div>
					<select id="skill_from">
						<option>Division 1</option>
						<option>Division 2</option>
						<option>Division 3</option>
						<option>Division 4</option>
						<option>Division 5</option>
						<option>Division 6</option>
					</select>
					<select id="skill_to">
						<option>Division 1</option>
						<option>Division 2</option>
						<option>Division 3</option>
						<option>Division 4</option>
						<option>Division 5</option>
						<option>Division 6</option>
					</select>
				</form>
			</li>
			<li class="profile_panel">';
			echo $user->mainuser($id) .'
			</li>
			<li class="friends_panel">
				<h1>Friends</h1>
				<ul>'; echo getfriends($user->id); echo '
				</ul>
			</li>
		</ul>
		<div id="content">
			<ul id="lobby_list">';
				echo $lobby->displaylobbies(1); echo $lobby->displaylobbies(2).'
			</ul>
		</div>
	</div>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
';
}
else header('Location: login.php');
?>