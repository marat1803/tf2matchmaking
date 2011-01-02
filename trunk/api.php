<?php


require_once 'includes/header.php';

$uid = esc_int($_SESSION['id']);
$lid = esc_int($_REQUEST['id']);
$request = $_GET['request'];
$method = $_GET['method'];

if ($method == "read") {
	if ($uid) $user = new User($uid);

	if ($request == "lobbyinfo" && $lid) {
		$lobby = new Lobby($lid);
		echo json_encode($lobby->lobbyinfo());
	}

	if ($request == "lobbyplayers" && $lid) {
			$lobby = new Lobby($lid);
			echo json_encode($lobby->lobbyData());
	}

	if ($request == "userready" && $lid && uid) {
		$lpid = getLPid($uid,$lid);
		$status = readyStatus($lpid,true);
		echo json_encode($status);
	}
}

if ($method == "write") {
	
}

?>