<?php


require_once 'includes/header.php';

$uid = $_SESSION['id'];
$lid = $_GET['id'];
$request = $_GET['request'];
$method = $_GET['method'];
$team = $_GET['team'];
$class = $_GET['class'];
$ready = $_GET['ready'];
$id = getLPid($uid,$lid);


if ($method == "read") {
	if ($uid) $user = new User($uid);

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
}

if ($method == "write") {
	if ($uid && $lid && isset($team) && $request == "changeTeam") {
		joinTeam($id, $team);
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

}

?>