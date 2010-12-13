<?php

require_once 'includes/header.php';

$uid = esc_int($_SESSION['id']);
$lid = esc_int($_REQUEST['id']);
$team = esc_int($_POST['team']);


if(lobbystatus($lobby->lobbystatus($lid)) == "Finished" && isPlayerInLobby($uid) == $lid) {
	echo "do stuff";
}
	elseif (lobbystatus($lobby->lobbystatus($lid)) == "In Progress" && isPlayerInLobby($uid) == $lid) {
		$server = new server($lobby->lobbyserver($lid));
		$server->joinServer($lobby->lobbyserver($lid));
	}
		elseif(isset($team) && isset($lid))
		{
			$lpid = getLPid($uid,$lid);
				if (freeslots($lid,$team) > 0) {
					joinTeam($lpid,$team);
				} else {
					echo 'Team is full.';		
				}
			redirect('lobby.php?id='.$lid,0);
		}
			else
			{
				if (!isPlayerInLobby($uid)) joinLobby($uid,$lid);
					else echo "You are already in a lobby !";
				if (isPlayerInLobby($uid) == $lid) {
					displaylobby($lid); echo '

					<form name="team" action="lobby.php" method="post">
						<input type="hidden" name="id" value="'.$lid.'">
						<input type="submit" name="team" value="1" />
						<input type="submit" name="team" value="2" />
					</form> ';
				}
			 } 
 ?>