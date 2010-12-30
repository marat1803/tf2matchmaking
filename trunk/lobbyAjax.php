<?php


require_once 'includes/header.php';

$uid = esc_int($_SESSION['id']);
$lid = esc_int($_REQUEST['id']);
$team = esc_int($_POST['team']);
$start = esc_int($_POST['start']);
$ready = esc_int($_POST['ready']);

$lobby = new Lobby($lid);
$user = new User($uid);

echo json_encode($lobby->lobbyData());

?>