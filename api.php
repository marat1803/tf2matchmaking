<?php


require_once 'includes/header.php';

$uid = esc_int($_SESSION['id']);
$lid = esc_int($_REQUEST['id']);
$request = $_GET['request'];


if ($uid) $user = new User($uid);

if ($request == "lobbydata" && $lid) {
	if ($lid) {
		$lobby = new Lobby($lid);
		echo json_encode($lobby->lobbyData());
	}
}

if ($request == "userready" && $lid && uid) {
	$lpid = getLPid($uid,$lid);
	$status = readyStatus($lpid);
	echo json_encode($status);
}

?>