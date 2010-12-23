<?php

require_once 'includes/header.php';

$server = $_GET['server'];
$port = $_GET['port'];
$rcon = $_GET['rcon'];
$players = $_GET['players']/2;
$config = $_GET['config'];

$srcds_rcon = new srcds_rcon();
$getconfig = file_get_contents('configs/'.$players.'vs'.$players.'/'.$config.'.cfg');
$commands = explode("\n", $getconfig);
foreach ($commands as $command) {
	$srcds_rcon->rcon_command($server, $port, $rcon, $command);
}

?>