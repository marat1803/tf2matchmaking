<?php

function getOnline ($id)
{
	$sql = 'SELECT * FROM users WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
	$users = mysql_fetch_assoc($query);
	$lastseen = $users['lastseen'];
	if ((time() - strtotime($lastseen)) > (5 * 60)) return "Offline";
	else return "Online";
}


function getfriends ($id) {
	$query = 'SELECT friends FROM users WHERE id='.mysql_real_escape_string($id);
	$result = mysql_query($query);
	$friendsinfo = mysql_fetch_assoc($result);	
	$fids = $friendsinfo['friends'];
	if ($fids != "" && count($fids) > 0) {
		$query = 'SELECT * FROM users WHERE id IN(' . mysql_real_escape_string($fids) .') ORDER BY lastseen DESC LIMIT 10';
		$result = mysql_query($query);
		while ($friend = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$online = getOnline($friend['id']);			
			$nickname = $friend['nickname'];
			$steamid = $friend['steamid'];
			$uid = $friend['id'];
			if ($online == "Online") $status = '<li>';
				else $status = '<li class="friend_offline">';
			$return = $status.'<a href = "profile.php?id='.$uid.'">
			<img src='.APIGet($steamid,avatar).' width="32" height="32"></img>'.
			'<span class="user_name">'.$nickname.'</span>'.
			'<span class="user_steamid">'.GetAuthID($steamid).'</span>'.
			'<span class="user_steamon">'.$online.'</span><br />
			</a></li>';
			echo $return;
		
		}
	} else echo 'You have no friends yet';
	
}

function addFriend ($id,$target) {
        $sql = 'SELECT friends FROM users WHERE id = '.mysql_real_escape_string($id);
        $query = mysql_query($sql);
        $result = mysql_fetch_assoc($query);
        $friends = $result['friends'];
        $fids = explode(",", $friends);
        foreach($fids as $fid) {
                if ($fid == $target) $true = 1;  }
        if ($true != 1) {
                if ($target == $id) echo "You can't friend yourself.";
                else {
                        if ($friends == "") $friends .= $target; 
                        else $friends .= ','.$target;
                        $sql = "UPDATE users SET friends = '".mysql_real_escape_string($friends)."' WHERE id = ".mysql_real_escape_string($id);
                        $query = mysql_query($sql);
                }
        }
                else echo 'You already friend with this player.';
}

?>