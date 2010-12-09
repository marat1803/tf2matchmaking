<?php

require_once 'includes/header.php';

$uid = $_SESSION['id'];
$lid = $_REQUEST['id'];
$team = $_POST['team'];

/*if (lobbystatus($lid) == "In Progress") {
	$server = new server($lobby->lobbyserver($lid));
	$server->joinServer($lobby->lobbyserver($lid));
	exit;
}*/
if(isset($team) && isset($lid))
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
	if (isPlayerInLobby($uid) == $lid) {
		displaylobby($lid); echo '

		<form name="team" action="lobby.php" method="post">
			<input type="hidden" name="id" value="'.$lid.'">
			<input type="submit" name="team" value="1" />
			<input type="submit" name="team" value="2" />
		</form> ';
	}

 } ?>