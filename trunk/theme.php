<?php

require 'includes/header.php';
$id = 1;

		
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
					<li>25 open lobbys</li>
					<li>23 lobbys in play</li>
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
				<ul>';
				foreach(queryfr($user->id) as $friend) {
				echo $friend;
				} echo '
				</ul>
			</li>
		</ul>
		<div id="content">
			<ul id="lobby_list">';
				echo $lobby->displaylobby($id).'
				<li class="lobby_panel" id="lobbyid:2">
					<img class="map_pic" src="theme/images/maps/cp_granary.jpg">
					<div class="panel_left">
						<h1>Lobby Name goes Here</h1>
						<span class="date">4:16 pm</span>
						<span class="map">cp_granary</span>
						<ul class="classes">
							<li><img src="theme/images/class/scout.png" height="18"></li>
							<li><img src="theme/images/class/soldier.png" height="18"></li>
							<li><img src="theme/images/class/demo.png" height="18"></li>
							<li><img src="theme/images/class/heavy.png" height="18"></li>
							<li><img src="theme/images/class/sniper.png" height="18"></li>					
							<li><img src="theme/images/class/medic.png" height="18"></li>
						</ul>
					</div>
					<div class="panel_right">
						<span class="skillevel">Division 6</span>
						<span class="matchtype">6 vs. 6</span>
						<span class="playercount"><span class="currentplayers">8</span>/<span class="maxplayers">12</span></span>
					</div>
				</li>
				<li class="lobby_panel">
					<img class="map_pic" src="theme/images/maps/cp_granary.jpg">
					<div class="panel_left">
						<h1>Lobby Name goes Here</h1>
						<span class="date">4:16 pm</span>
						<span class="map">cp_granary</span>
						<ul class="classes">
							<li><img src="theme/images/class/scout.png" height="18"></li>
							<li><img src="theme/images/class/soldier.png" height="18"></li>
							<li><img src="theme/images/class/demo.png" height="18"></li>
							<li><img src="theme/images/class/heavy.png" height="18"></li>
							<li><img src="theme/images/class/sniper.png" height="18"></li>					
							<li><img src="theme/images/class/medic.png" height="18"></li>
						</ul>
					</div>
					<div class="panel_right">
						<span class="skillevel">Division 6</span>
						<span class="matchtype">6 vs. 6</span>
						<span class="playercount"><span class="currentplayers">8</span>/<span class="maxplayers">12</span></span>
					</div>
				</li>
				<li class="lobby_panel">
					<img class="map_pic" src="theme/images/maps/cp_granary.jpg">
					<div class="panel_left">
						<h1>Lobby Name goes Here</h1>
						<span class="date">4:16 pm</span>
						<span class="map">cp_granary</span>
						<ul class="classes">
							<li><img src="theme/images/class/scout.png" height="18"></li>
							<li><img src="theme/images/class/soldier.png" height="18"></li>
							<li><img src="theme/images/class/demo.png" height="18"></li>
							<li><img src="theme/images/class/heavy.png" height="18"></li>
							<li><img src="theme/images/class/sniper.png" height="18"></li>					
							<li><img src="theme/images/class/medic.png" height="18"></li>
						</ul>
					</div>
					<div class="panel_right">
						<span class="skillevel">Division 6</span>
						<span class="matchtype">6 vs. 6</span>
						<span class="playercount"><span class="currentplayers">8</span>/<span class="maxplayers">12</span></span>
					</div>
				</li>
				<li class="lobby_panel lobby_matched">
					<img class="map_pic" src="theme/images/maps/cp_granary.jpg">
					<div class="panel_left">
						<h1>Lobby Name goes Here</h1>
						<span class="date">4:16 pm</span>
						<span class="map">cp_granary</span>
						<ul class="classes">
							<li><img src="theme/images/class/scout.png" height="18"></li>
							<li><img src="theme/images/class/soldier.png" height="18"></li>
							<li class="class_available"><img src="theme/images/class/demo.png" height="18"></li>
							<li><img src="theme/images/class/heavy.png" height="18"></li>
							<li><img src="theme/images/class/sniper.png" height="18"></li>					
							<li><img src="theme/images/class/medic.png" height="18"></li>
						</ul>
					</div>
					<div class="panel_right">
						<span class="skillevel skill_matched">Division 4</span>
						<span class="matchtype">6 vs. 6</span>
						<span class="playercount"><span class="currentplayers">8</span>/<span class="maxplayers">12</span></span>
					</div>
				</li>
				<li class="lobby_panel">
					<img class="map_pic" src="theme/images/maps/cp_granary.jpg">
					<div class="panel_left">
						<h1>Lobby Name goes Here</h1>
						<span class="date">4:16 pm</span>
						<span class="map">cp_granary</span>
						<ul class="classes">
							<li><img src="theme/images/class/scout.png" height="18"></li>
							<li><img src="theme/images/class/soldier.png" height="18"></li>
							<li><img src="theme/images/class/demo.png" height="18"></li>
							<li><img src="theme/images/class/heavy.png" height="18"></li>
							<li><img src="theme/images/class/sniper.png" height="18"></li>					
							<li><img src="theme/images/class/medic.png" height="18"></li>
						</ul>
					</div>
					<div class="panel_right">
						<span class="skillevel">Division 6</span>
						<span class="matchtype">6 vs. 6</span>
						<span class="playercount"><span class="currentplayers">8</span>/<span class="maxplayers">12</span></span>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
';
?>