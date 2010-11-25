<?php

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

if (($steamid) == "") {
echo '<style type="text/css">
.login {
  width:114px;
  height:43px;
  background:url(login.png) no-repeat;
  text-indent:-9999px;
  border:none;
  cursor:pointer;
}
</style>
<form action="?login" method="post">
    <button class="login">Login with Steam</button>
</form>'; }
else {
$query = "SELECT * FROM users WHERE steamid = ". $steamid . " LIMIT 1 ";
$result = mysql_query($query); 
$row = mysql_fetch_assoc($result);

if (isset($result) && ($steamid == $row[steamid]))
		{
				$_SESSION['steamid'] = $steamid;
				header('Location: index.php');
		} else {
			if(isset($_POST['nickname'], $_POST['email'], $_POST['steamId64'])) {
				$nickname = substr($_POST['nickname'], 0, 80);
				$email = $_POST['email'];
				$steamid = (string)$_POST['steamId64'];
				$query = 'INSERT INTO `users` (`steamid`, `nickname`, `email`) VALUES(\'' .  mysql_real_escape_string($steamid) . '\', \'' .  mysql_real_escape_string($nickname) . '\', \'' .  mysql_real_escape_string($email) . '\');';
				mysql_query($query) or die("Error in query: $result. ".mysql_error());
				echo '<p>Welcome, ' . $nickname . '</p>'
					.'<p>Your account has been successfully created.</p>';
					$_SESSION['steamid'] = $steamid;
			} else {
				echo '<form method="post" action="">'
					.'<input type="hidden" name="steamId64" value="' . $steamid . '">'
					.'<input type="text" name="nickname"/>'
					.'<input type="text" name="email">'
					.'<input type="submit">'
					.'</form>';
			}
		}
}
?>