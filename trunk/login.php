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

if (isset($result) && ($steamid == $row[steamid]))
		{
				$_SESSION['steamid'] = $steamid;
				$_SESSION['id'] = displayID($steamid);
				header('Location: index.php');
		} else {
			if(isset($_POST['nickname'], $_POST['email'], $_POST['steamId64'])) {
				$nickname = substr($_POST['nickname'], 0, 80);
				$email = $_POST['email'];
				$steamid = (string)$_POST['steamId64'];
				$query = "INSERT INTO `users` (`steamid`, `nickname`, `email`, `country`) VALUES('" .  mysql_real_escape_string($steamid) . "', '" .  mysql_real_escape_string($nickname) . "', '" .  mysql_real_escape_string($email) . "','".mysql_real_escape_string($_POST['loc'])."');";
				mysql_query($query) or die("Error in query: $result. ".mysql_error());
				$sql = "INSERT INTO `ratings` (`id`) VALUES (".mysql_real_escape_string(displayID($steamid)).")";
				mysql_query($sql);
				echo '<p>Welcome, ' . $nickname . '</p>'
					.'<p>Your account has been successfully created.</p>';
					$_SESSION['steamid'] = $steamid;
					$_SESSION['id'] = displayID($steamid);
					
					echo '<meta http-equiv="refresh" content="6;url=index.php">';
			} else {
				//get default information from Steam API
				//this will get nickname and things
			$xml = simplexml_load_file('http://steamcommunity.com/profiles/'.$steamid.'?xml=1');
	
			echo '<style type="text/css">
			fieldset{
				margin:0px auto 0px auto;
				width:500px;
			}
			input[type="text"]{
				width:100%;
			}
			table{
				margin-top:20px;
			}
			td{width:50%;vertical-align:top;}
			tr td{
				border-bottom:thin solid black;
			}
			tr:first-child td{border-top:thin solid black;}
			tr:last-child td{
				border-bottom:none;
				text-align:center;
			}
			</style>
			
	<fieldset>
	<legend>Welcome!</legend>
	Thank you for using TF2MM! Since this is the first time you\'ve used TF2MM, we\'d like to know more about you. Entering this information is completely optional and not required, but will aid in better match making.
	<form method="post" action="">
	<input type="hidden" name="steamId64" value="' . $steamid . '">
	<table>
		<tr>
			<td>Nickname:<br />(Cannot be blank)</td>
			<td><input type="text" value="'.$xml->steamID.'" name="nickname"/></td>
		</tr>
		<tr>
			<td>Email:<br />(Important messages and updates will be sent. Can opt-out at any time)</td>
			<td><input type="text" name="email"/></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><input type="text" name="loc" value="'.APIGet($steamid,loccountrycode).'" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Submit" /></td>
		</tr>
	</table></form>
	</fieldset>';
			}
		}
}
?>