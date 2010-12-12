<?php
function GetAuthID($i64friendID)
{
	$tmpfriendID = $i64friendID;
	$iServer = "1";
	if(bcmod($i64friendID, "2") == "0")
	{
		$iServer = "0";
	}
	$tmpfriendID = bcsub($tmpfriendID,$iServer);
	if(bccomp("76561197960265728",$tmpfriendID) == -1)
		$tmpfriendID = bcsub($tmpfriendID,"76561197960265728");
	$tmpfriendID = bcdiv($tmpfriendID, "2");
	return ("STEAM_0:" . $iServer . ":" . (int)$tmpfriendID);
}


function APIGet ($steamid,$what)
{
	if($what == 'avatar') {
		clearstatcache();
		if(!file_exists('cache/avatars/'.$steamid.'.jpg')) {
			$api = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0001/?key=8DEE586C5830B73298B0C2F06D330E3C&steamids='. $steamid);
			$result = json_decode($api);
			$avatar = $result->response->players->player[0]->$what;
			$filename = 'cache/avatars/'.$steamid.'.jpg';
			copy($avatar, $filename);
			
			return 'cache/avatars/'.$steamid.'.jpg';
		} else {
			return 'cache/avatars/'.$steamid.'.jpg';
		}
	} else {
		$api = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0001/?key=8DEE586C5830B73298B0C2F06D330E3C&steamids='. $steamid);
		$result = json_decode($api);
		return $result->response->players->player[0]->$what;
	}
}
?>