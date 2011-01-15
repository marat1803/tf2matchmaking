<?php

require_once 'includes/header.php';

$css = 'style.css';


$pid = $_SESSION['id'];
$lid = $_REQUEST['id'];
$id = getLPid($pid,$lid);

$lobby = new Lobby($lid);
$user = new User($pid);
$sid = $lobby->lobbyserver($lid);
$server = new Server($sid);


switch ($lobby->status) {
		case "open":
			$js = 'lobby.js';
			$ready = false;
			include_once 'includes/header.inc';
			include_once 'includes/pages/lobby.inc';
			break;
		case "ready":
			$js = 'lobby.js';
			$ready = true;
			include_once 'includes/header.inc';
			include_once 'includes/pages/lobby.inc';
			break;
		case "ingame":
		case "finished":
		case "closed":
			$js = 'lobby_start.js';
			include_once 'includes/header.inc';
			include_once 'includes/pages/lobby_start.inc';
			$server = new Server($lobby->lobbyserver($lid));
			$server->joinServer($lobby->lobbyserver($lid));
			break;
}

/*
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

*/
 ?>