<?php
//Maybe if I revert back to the original it'll be easier?
require_once 'includes/header.php';
require 'openid.inc';
try {
    if(!isset($_GET['openid_mode'])) {
        if(isset($_GET['login'])) {
            $openid = new LightOpenID;
            $openid->identity = 'https://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }

    } elseif($_GET['openid_mode'] == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        $openid = new LightOpenID;
		$openid->validate();
		$steamid = basename($openid->identity);
		if(!$steamid) {
			echo 'Auth failed';
			exit;
		}
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
$steamid = basename($openid->identity);


$total = "3"; 
$file_type = ".jpg"; 
$start = "1"; 
$random = mt_rand($start, $total); 
$image_name = $random . $file_type; 

if (($steamid) == "") {
echo '<link href="theme/style.css" rel="stylesheet" type="text/css" /><style type="text/css">
body{
//background: #FFFFFF;
}
</style>
<div id="container">
<div id="position">
 <div class="loginbg" style="background-image:url(theme/images/splash/'.$image_name.')"><form action="?login" method="post">
    <button class="login">Login with Steam</button>
</form></div></div>'; }
else {
$query = "SELECT * FROM users WHERE steamid = ". mysql_real_escape_string($steamid) . " LIMIT 1 ";
$result = mysql_query($query); 
$row = mysql_fetch_assoc($result);

if (isset($result) && ($steamid == $row['steamid']))
		{
				$_SESSION['steamid'] = $steamid;
				$_SESSION['id'] = User::get_id($steamid);
				header('Location: index.php');
		} else {
			if(isset($_POST['nickname'], $_POST['email'], $_POST['steamId64'])) {
				$nickname = substr($_POST['nickname'], 0, 80);
				$email = $_POST['email'];
				$steamid = (string)$_POST['steamId64'];
				$query = "INSERT INTO `users` (`steamid`, `nickname`, `email`, `country`) VALUES('" .  mysql_real_escape_string($steamid) . "', '" .  mysql_real_escape_string($nickname) . "', '" .  mysql_real_escape_string($email) . "','".mysql_real_escape_string($_POST['loc'])."');";
				mysql_query($query) or die("Error in query: $result. ".mysql_error());
				$sql = "INSERT INTO `ratings` (`id`) VALUES (".mysql_real_escape_string(User::get_id($steamid)).")";
				mysql_query($sql);
				echo 'Your account has been successfully created.';
					$_SESSION['steamid'] = $steamid;
					$_SESSION['id'] = User::get_id($steamid);
					
					//echo '<meta http-equiv="refresh" content="6;url=index.php">';
			} else {
				//get default information from Steam API
				//this will get nickname and things
			$xml = simplexml_load_file('http://steamcommunity.com/profiles/'.$steamid.'?xml=1');
	
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
			<a href="" id="logo">TF2 Matchmaking System</a>
		</div>
		<div id="content" class="big_panel">
			<ul class="nav_panel">
				<li><a href="index.html">Home</a></li>
				<li class="current"> &raquo; Register</li>
			</ul>
		<h1 style="float: left; font-size: 3em; width: 90%; text-align: center; border-bottom: 1px solid; margin: 20px 5%; padding-bottom: 10px;">Welcome!</h1>
		<form method="post" action="" style="margin-top: 10px;">
		<input type="hidden" name="steamId64" value="' . $steamid . '">
			<p style="margin: 10px 50px;">Thank you for using TF2MM! Since this is the first time you\'re using TF2MM, we\'d like to know more about you.</p>
			<div class="panel" style="width: 500px; margin-left: 50px;">
				<label>Nickname:</label>
				<input type="text" value="' .$xml->steamID. '" name="nickname"/><small style="float: left;margin: 3px;">(Cannot be blank)</small>
			</div>
			<input type="submit" style="float: right; width: 250px; margin-right:54px;  margin-bottom: 0;" value="Submit" class="button submit" />
			<div class="panel" style="width: 500px; margin-left: 50px;">
				<label>Email:</label>
				<input type="text" name="email"/><small style="float: left;margin: 3px;">(Can opt-out at any time)</small>
				<label>Country:</label>
				<input type="text" name="loc" value="'.APIGet($steamid,loccountrycode).'" />
			</div>
			<p style="float: right; width: 250px; margin-right:50px; margin-top: 0;">Entering this information is completely optional and not required, but will aid in better match making.</p>
		</form>
	</div>
	<script src="theme/js/jquery.js" type="text/javascript"></script>
	<script src="theme/js/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="theme/js/register.js" type="text/javascript"></script>
</body>
</html>';
			}
		}
}
?>