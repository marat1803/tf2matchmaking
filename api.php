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
	$count = countPlayers($lid);
	$array = array(
		'id' => $uid,
		'ready' => readystatus($id,true),
		'inlobby' => isPlayerInLobby($uid),
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
	$status = readystatus($id,true);
	$lobby = new Lobby($lid);
	$leader = $lobby->lobbyLeader();
	$array = array(
		'ready' => $status,
		'leader' => $leader);
	echo json_encode($array);
}

if ($lid && $request == "distance" && $lat && $lon)
	{
		$lobby = new Lobby($lid);
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

if ($uid && $lid && $request == "startGame") {
	startLobby($lid);
	$lobby = new Lobby($lid);
	$server = new Server($lobby->lobbyserver($lid));
	$players = teamplayers($lobby->type)*2;
	$server->loadConfig($players,etf2l);
}

if ($uid && $fid && $request == "addFriend") {
	addFriend($uid,$fid);
}

if ($uid && $lid && $request == "joinGame") {
	if (!isPlayerInLobby($uid)) joinLobby($uid,$lid);
}

if($uid && $request == "newLobby") {
	if (isPlayerInLobby($uid)) {
		$name = $_POST['name'];
		$type = $_POST['type'];
		$region = '';
		$map  = $_POST['map'];
		$division = '';
		$sid = 2;
		$lastInsertId = newLobby($name,$type,$region,$map,$division,$uid,$sid);
		joinLobby($uid,$lastInsertId);
		if($lastInsertId) {
			echo $lastInsertId;
		}
	} else {
		echo '0';
	}
}

if($uid && $request == "rate") {
	$lid    = $_POST['lid'];
	$id = getLPid($uid,$lid);
	$target = $_POST['userid'];
	$value  = $_POST['value'];
	rate($id, $target, $value);

}

?>