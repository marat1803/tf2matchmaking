<?php

require 'includes/header.php';
$css = 'style.css';
$js = 'main.js';
if(isset($_SESSION['id'])) {

$id = $_SESSION['id'];

$user = new User($id);
include_once 'includes/header.inc';

}


$db = Database::obtain();

			if ($id) {
			echo '<ul id="sidebar">
			<li class="play_now_button">Play Now!</li>
			<li id="lobby_filter">
				<ul id="lobbys_opened">
					<li>'.countLobbies(open).' open lobbies</li>
					<li>'.countLobbies(ingame).' lobbies in play</li>
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
			<li class="profile_panel">'
			.$user->display_profile($id) .'
			</li>
			<li class="friends_panel">
				<h1>Friends</h1>
				<ul>'; echo getfriends($user->id); echo '
				</ul>
			</li>';
			} else {
			 	require 'openid.inc';
			 	try {
			    if(!isset($_GET['openid_mode'])) {
			        if(isset($_GET['login'])) {
			            $openid = new LightOpenID;
			            $openid->identity = 'https://steamcommunity.com/openid';
			            header('Location: ' . $openid->authUrl());
			        }

			    } elseif($_GET['openid_mode'] == 'cancel') {
			        echo 'User has canceled authentication!';
			    } else {
			        $openid = new LightOpenID;
					$openid->validate();
					$steamid = basename($openid->identity);
					if(!$steamid) {
						echo 'Auth failed';
						exit;
					}
			    }
				} catch(ErrorException $e) {
				    echo $e->getMessage();
				}
				$steamid = basename($openid->identity);
				include_once 'includes/header.inc';
				if ($steamid != "") {
					$sql = "SELECT * FROM users WHERE steamid = ". $db->escape($steamid);
					$query = $db->query($sql); 
					$result = $db->fetch($query);
					if (isset($result) && ($steamid == $result['steamid'])) {
						$_SESSION['id'] = User::get_id($result['steamid']);
						$_SESSION['steamid'] = $steamid;
						redirect('index.php',0);
					} else redirect('register.php',0);
				} else {
					echo '<ul id="sidebar">
			<li><form action="?login" method="post"><input type="submit" class="button sign_up" value="Sign up!" /></form></li>
			<li id="lobby_info">
				<img src="theme/images/login_small.png" style="margin-left: 25px;">
			</li>';
				}
			}
		echo '
		</ul>
		<div id="content">
			<ul id="lobby_list">';
				echo displaylobbies(1); echo displaylobbies(2).'
			</ul>
		<div class="small button bottom_nav">
				+ Create your own lobby
			</div>
		</div>
	</div>
</body>
</html>
';

?>