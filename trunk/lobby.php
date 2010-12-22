<?php

require_once 'includes/header.php';

$uid = esc_int($_SESSION['id']);
$lid = esc_int($_REQUEST['id']);
$team = esc_int($_POST['team']);
$start = esc_int($_POST['start']);
$ready = esc_int($_POST['ready']);


if ($start == 1) changeLobby($lid,status,ready);
if ($ready == 1) readyStatus(getLPid($uid,$lid),1);

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
				displaylobby($lid); 
				echo '
						<form name="ready" action="lobby.php" method="post">
						<input type="hidden" name="id" value="'.$lid.'">
						<input type="submit" name="ready" value="1" />
						</form>';
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
							<input type="submit" name="start" value="1" />
							</form>';
						}
							
					}
				 } 
 ?>