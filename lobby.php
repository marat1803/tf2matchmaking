<?php

require_once 'includes/header.php';

$uid = $_SESSION['id'];
$lid = $_REQUEST['id'];
$team = $_POST['team'];


if(isset($team) && isset($lid))
{
	$lpid = getLPid($uid,$lid);
	joinTeam($lpid,$team);
	header('Location: lobby.php?id='.$lid);
}
else
{
	joinLobby($uid,$lid);
	displaylobby($lid); echo '

	<form name="team" action="lobby.php" method="post">
		<input type="hidden" name="id" value="'.$lid.'">
		<input type="submit" name="team" value="1" />
		<input type="submit" name="team" value="2" />
	</form> ';
 } ?>