<?php
// This is just a test
require 'includes/header.php';

if(isset($_SESSION['steamid'])) {

$id = displayID($_SESSION['steamid']);

$user = new user($id);

$css = 'style.css';
$js = 'main.js';

include_once 'includes/header.inc';

		
echo '
		<ul id="sidebar">
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
				echo displaylobbies(1); echo displaylobbies(2).'
			</ul>
		</div>
	</div>
</body>
</html>
';
}
else header('Location: login.php');
?>