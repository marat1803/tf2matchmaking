<?php
/*	#####################################
	#				TF2MM				#
	#									#
	#	Login.php	-- R3				#
	#									#
	#	Stephen Costeira				#
	#	11/26/10						#
	#####################################
	
	-Need to look over this openid stuff below
		--rearrange logic: ?login -- forward to openid provider
		--it's all there, but in an odd way
*/


require_once('includes/header.php');
require_once('openid.inc');
require_once('includes/steam_api.php');
try{
    if(!isset($_GET['openid_mode'])) {
        if(isset($_GET['login'])) {
            $openid = new LightOpenID;
            $openid->identity = 'https://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
    }elseif($_GET['openid_mode'] == 'cancel'){
        echo 'User has canceled authentication!';
    }else{
        $openid = new LightOpenID;
		$openid->validate();
		$steamid = basename($openid->identity);
		if(!$steamid) {
			die('Auth failed');
		}
    }
}catch(ErrorException $e){
    echo $e->getMessage();
}
$steamid = basename($openid->identity);



// </> End Review


if($steamid == ""){
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
</form>';
}else{
	//yay logged in through steam
	
	
	
	// 'HEY, THIS GUY LOGGED IN; HAS HE LOGGED IN BEFORE?'
	$sql = 'SELECT * FROM `users` WHERE `steamid`="'.mysql_real_escape_string($steamid).'"'; //is escaping this necessary?
	$result = mysql_query($sql);
	$res = mysql_fetch_array($result);
	//check
	if($res['id'] != ''){ //YEAH HE WAS HERE BEFORE
		echo 'Welcome back';
		$_SESSION['steamid'] = $res;
	}else{//NO MAN, SETUP NEW ACCOUNT
	
		//get information from Steam API
			//this will get nickname and things
		$xml = simplexml_load_file('http://steamcommunity.com/profiles/'.$steamid.'?xml=1');
		//Insert info
		if(!mysql_query("INSERT INTO `users` (steamid,nickname,online,country,regdate) VALUES ('".$steamid."','".$xml->steamID."','".$xml->onlineState."','".$xml->location."','".time()."')")){
			die('Error: ' . mysql_error());
		}else{
			//everything went fine
			header('Location: index.php');
		}
	}
}


?>