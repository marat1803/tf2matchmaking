<?php

require_once 'includes/header.php';

$id = $_GET['id'];
$steamid = displaySteamID($id);

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>TF2 Matchmaking System</title>
    <link href="theme/style_profile.css" rel="stylesheet" type="text/css" />
    <link href="theme/uniform.default.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="background_image"></div>
    <div id="wrapper">
        <div id="header">
            <a href="index.php" id="logo">TF2 Matchmaking System</a>
        </div>
        <div id="content" class="big_panel">
            <ul class="nav_panel">
                <li><a href="index.php">Home</a></li>
                <li class="current"> &raquo; Profile (far from being finished, but at least some progress)</li>
            </ul>
            <div class="avatar_panel">
                <img class="avatar_big" src="'.APIGet($steamid,avatarfull).'">';
if($steamid != $_SESSION['steamid']) {
	echo '<a href="addfriend.php?id='.$id.'" class="friend_add button">+ Add</a>';
}
            echo '</div>
            '.$user->profileuser($id).'
            <dl class="stats_panel">
                <dt>Wins</dt><dd>7</dd>
                <dt>Losses</dt><dd>10</dd>
                <dt>Ratio</dt><dd>0.7</dd>
            </dl>
            <div class="friends_panel">
                <h1>Friends</h1>
                <ul>';
                echo getfriends($id).'
                </ul>
            </div>
    </div>
    <script src="theme/js/jquery.js" type="text/javascript"></script>
    <script src="theme/js/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="theme/js/main.js" type="text/javascript"></script>
</body>
</html>';


	
?>