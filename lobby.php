<?php

require_once 'includes/header.php';

$css = 'style.css';
$js = 'lobby.js';
$uid = $_SESSION['id'];
$lid = $_REQUEST['id'];
$team = esc_int($_POST['team']);
$start = esc_int($_POST['start']);
$ready = esc_int($_POST['ready']);

$lobby = new Lobby($lid);
$user = new User($uid);

include_once 'includes/header.inc';

echo '<ul id="sidebar">
			<li class="button ready_up">Ready Up!</li>
			<li class="button ready_off">Unready!</li>
			<li class="button join_game">Start Game!</li>
			<li id="lobby_info">
				<dl>
					<dt>Name:</dt><dd>Test Server</dd>
					<dt>IP:</dt><dd>127.0.0.1</dd>
					<dt>Location:</dt><dd>Amsterdam</dd>
					<dt>Rules:</dt><dd>ETF2L 6 vs. 6</dd>	
				</dl>	
			</li>
			<li class="profile_panel">';
			echo $user->display_profile($uid) .'
			<h1 style="margin-top: 10px;">Settings</h1>
				<ul class="class_list">
		            <li class="scout"><img src="theme/images/class/scout.png" /></li>
		            <li class="soldier"><img src="theme/images/class/soldier.png" /></li>
		            <li class="pyro"><img src="theme/images/class/pyro.png" /></li>
		            <li class="demoman selected"><img src="theme/images/class/demo.png" /></li>
		            <li class="heavy"><img src="theme/images/class/heavy.png" /></li>
		            <li class="engineer"><img src="theme/images/class/engineer.png" /></li>
		            <li class="medic"><img src="theme/images/class/medic.png" /></li>
		            <li class="sniper"><img src="theme/images/class/sniper.png" /></li>
		            <li class="spy"><img src="theme/images/class/spy.png" /></li>
		            <li class="random"><img src="theme/images/class/noclass.png" /></li>
         		</ul>
				<span class="team_switch">
					<span class="join_blu join_active"></span>
					<span class="join_spec"></span>
					<span class="join_red"></span>
				</span>
			</li>
			<li class="friends_panel">
				<h1>Friends</h1>
				<ul>'; echo getfriends($uid,true); echo '
				</ul>
			</li>
		</ul>
		<div id="content">
			<ul id="lobby_list">';


if ($start == 1) changeLobby($lid,status,ready);
if ($ready == 1) readyStatus(getLPid($uid,$lid),true);

if(lobbystatus($lobby->lobbystatus($lid)) == "Finished" && isPlayerInLobby($uid) == $lid) {
	echo "ratings";
}
	elseif (lobbystatus($lobby->lobbystatus($lid)) == "In Progress" && isPlayerInLobby($uid) == $lid) {
		$server = new server($lobby->lobbyserver($lid));
		$server->joinServer($lobby->lobbyserver($lid));
	}
		elseif($team > 0 && isset($lid))
		{
			$lpid = getLPid($uid,$lid);
				if (freeslots($lid,$team) > 0) {
					joinTeam($lpid,$team);
				} else {
					echo 'Team is full.';		
				}
			redirect('lobby.php?id='.$lid,0);
		}
			elseif (lobbystatus($lobby->lobbystatus($lid)) == "Ready Phase" && isPlayerInLobby($uid) == $lid) {
				displaylobby($lid, true); 
			}
				else
				{
					if (!isPlayerInLobby($uid)) joinLobby($uid,$lid);
						else echo "You are already in a lobby !";
					if (isPlayerInLobby($uid) == $lid) {
						displaylobby($lid); 
						echo '
							<form name="team" action="lobby.php" method="post">
							<input type="hidden" name="id" value="'.$lid.'">
							<input type="submit" name="team" value="1" />
							<input type="submit" name="team" value="2" />
							</form> ';
						if (countPlayers($lid) == 12) {
							echo '
							<form name="start" action="lobby.php" method="post">
							<input type="hidden" name="id" value="'.$lid.'">
							<input type="submit" name="start" value="Start" />
							</form>';
						}
							
					}
				 } 

echo '
</div>
</body>
</html>';
 ?>