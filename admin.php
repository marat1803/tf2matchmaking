<?php

require_once 'includes/header.php';
$css = 'style_profile.css';
include_once 'includes/header.inc';


$id = $_SESSION['id'];
$post = false;

if ($id) $user = new User($id);

if ($user->status == "admin") {
	switch ($_GET['page']) {
		case "banuser":
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$post = true;
				if (isset($_POST['user']) && isset($_POST['reason']) && isset($_POST['lobby'])) {
					if ($_POST['reason'] == 'custom') {
						if (isset($_POST['comment']) && isset($_POST['amount'])) $message = newBanPoints($_POST['user'],$_POST['lobby'],$id,$_POST['reason'],$_POST['amount'],$_POST['comment']);
						else $error = 'Both comment and amount field must be filled';
					} else $message = newBanPoints($_POST['user'],$_POST['lobby'],$id,$_POST['reason'],$_POST['amount'],$_POST['comment']);
				}
				include_once 'includes/pages/adminban.inc';
			} else include_once 'includes/pages/adminban.inc';
		case "userslist":
			$page = $_GET['page'];
			$userlist = usersList($page);
			include_once 'includes/pages/adminusers.inc';
	}
} else header('Location: index.php');


?>