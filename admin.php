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
			break;
		case "userslist":
			$page = $_GET['page'];
			$userlist = usersList($page);
			include_once 'includes/pages/adminusers.inc';
			break;
		case "banslist":
			include_once 'includes/pages/adminbans.inc';
			break;
		case "forum":
			if ($_GET['action'] == 'newTopic') {
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['message'])) {
					$topic = newTopic($_POST['name'],$id,$_POST['message']);
					redirect('admin.php?page=forum&topic='.$topic,0);
				} else include_once 'includes/pages/adminnewtopic.inc';
			} elseif ($_GET['action'] == 'newPost' && $_GET['topic']) {
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
					newPost($_GET['topic'],$id,$_POST['message']);
					redirect('admin.php?page=forum&topic='.$_GET['topic'],0);
				} else include_once 'includes/pages/adminnewpost.inc';
			} elseif ($_GET['topic']) {
				$topic = Topic($_GET['topic']);
				include_once 'includes/pages/adminposts.inc';
			}
			else include_once 'includes/pages/adminforum.inc';
			break;
	}
} else redirect('index.php',0);


?>