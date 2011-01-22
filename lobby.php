<?php

require_once 'includes/header.php';

$css = 'style.css';


$pid = $_SESSION['id'];
$lid = $_REQUEST['id'];

if ($pid) {

	$id = getLPid($pid,$lid);

	$lobby = new Lobby($lid);
	$user = new User($pid);
	$sid = $lobby->lobbyserver($lid);
	$mid = $lobby->mid;
	$server = new Server($sid);
	$mumble = new Mumble($mid);

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

}
else header('Location: index.php');
 ?>