<?php

require_once 'includes/header.php';

$css = 'style_profile.css';

$id = $_SESSION['id'];

if ($id) {
	$user = new User($id);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($_POST['nickname'] != $user->nickname) $details['nickname'] = $_POST['nickname'];
		if ($_POST['email'] != $user->email) $details['email'] = $_POST['email'];
		if ($_POST['loc'] != $user->country) $details['country'] = $_POST['loc'];
		if ($details) {
			$user->updateDetails($details);
			$user = new User($id);
		}
	}

	include_once 'includes/header.inc';
	include_once 'includes/pages/usercenter.inc';


} else header('Location: index.php');

?>