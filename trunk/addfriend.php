<?php

require_once 'includes/header.php';

$target = $_GET['id'];
$id = $_SESSION['id'];

addFriend ($id,$target);
redirect('profile.php?id='.$target,0);

?>