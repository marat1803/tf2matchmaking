<?php

require 'includes/header.php';

if(isset($_SESSION['id'])) {

$page = $_GET['page'];
$pid = $_SESSION['id'];
$lid = $_GET['id'];

$user = new User($pid);

$css = "style.css";

if ($page == "index") $js = "main.js";
elseif ($page == "lobby") $js = $page.'.js';

include_once 'includes/header.inc';
include_once 'includes/pages/'.$page.'.inc';
}

else header('Location: login.php');

?>