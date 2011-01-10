<?php


require_once 'includes/header.php';

$uid = $_SESSION['id'];
$lid = $_GET['id'];
$request = $_GET['request'];
$team = $_GET['team'];
$class = $_GET['class'];
$ready = $_GET['ready'];
$lat = $_GET['latitude'];
$lon = $_GET['longitude'];
$fid = $_GET['fid'];


if ($uid) $user = new User($uid);
if ($lid) $id = getLPid($uid,$lid);

if ($request == "lobbyinfo" && $lid) {
	$lobby = new Lobby($lid);
	$lobbyinfo = $lobby->lobbyinfo();
	$lobbyplayers = $lobby->lobbyData();
	$count = countPlayers($id);
	$array = array(
		'ready' => readyStatus($id,true),
		'info' => $lobbyinfo,
		'count' => $count,
		'players' => $lobbyplayers);
	echo json_encode($array);
}

if ($request == "lobbyplayers" && $lid) {
		$lobby = new Lobby($lid);
		echo json_encode($lobby->lobbyData());
}

if ($request == "userready" && $lid && uid) {
	$status = readyStatus($id,true);
	$lobby = new Lobby($lid);
	$leader = $lobby->lobbyLeader();
	$array = array(
		'ready' => $status,
		'leader' => $leader);
	echo json_encode($array);
}

if ($lid && $request == "distance" && $lat && $lon)
	{
		$lobby = new Lobby($id);
		$server = new Server($lobby->lobbyserver($lid));
		echo GetDistance($lat,$lon,$server->latitude,$server->longitude);
	}

if ($uid && $lid && isset($team) && $request == "changeTeam") {
	if (freeslots($lid,$team) > 0) joinTeam($id, $team);
	echo freeslots($lid,$team);
}

if ($uid && $lid && isset($class) && $request == "switchClass") {
	switchClass($id, $class);
}

if ($uid && $lid && isset($ready) && $request == "readystatus") {
	readystatus($id, false, $ready);
}

if ($uid && lid && $request == "startGame") {
	startLobby($id);
}

if ($uid && $fid && $request == "addFriend") {
	addFriend($uid,$fid);
}


?>