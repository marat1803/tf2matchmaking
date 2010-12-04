<?php

require_once 'includes/header.php';

$target = $_GET['id'];
$id = $_SESSION['id'];

addFriend ($id,$target);
header('Location: profile.php?id='.target);

?>