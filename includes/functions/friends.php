<?php

function getOnline ($id)
{
	$db = Database::obtain();
	$sql = 'SELECT * FROM users WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
	$users = $db->fetch($query);
	$lastseen = $users['lastseen'];
	if ((time() - strtotime($lastseen)) > 60) return "Offline";
	else return "Online";
}


function getfriends ($id,$invite = false) {
	$db = Database::obtain();
	$query = 'SELECT friends FROM users WHERE id='.$db->escape($id);
	$result = $db->query($query);
	$friendsinfo = $db->fetch($result);	
	$fids = $friendsinfo['friends'];
	if ($fids != "" && count($fids) > 0) {
		$query = 'SELECT * FROM users WHERE id IN(' . $db->escape($fids) .') ORDER BY lastseen DESC LIMIT 10';
		$result = $db->query($query);
		while ($friend = $db->fetch($result)) {
			$online = getOnline($friend['id']);			
			$nickname = $friend['nickname'];
			$steamid = $friend['steamid'];
			$uid = $friend['id'];
			if ($online == "Online") $status = '<li>';
				else $status = '<li class="friend_offline">';
			if ($invite && $online == "Online") 
			$invitelink = '<a class="friend_inv" href="#invite" title="Invite to Lobby">Inv+</a>';
			$return = $status.'<a href = "profile.php?id='.$uid.'">
			<img src='.APIGet($steamid,avatar).' width="32" height="32"></img>'.
			'<span class="user_name">'.$nickname.'</span>'.
			'<span class="user_steamid">'.GetAuthID($steamid).'</span>'.
			'<span class="user_steamon">'.$online.'</span><br />
			'.$invitelink.'
			</a></li>';
			echo $return;
		
		}
	} else echo 'You have no friends yet';
	
}

function addFriend ($id,$target) {
	$db = Database::obtain();
    $sql = 'SELECT friends FROM users WHERE id = '.$db->escape($id);
    $query = $db->query($sql);
    $result = $db->fetch($query);
    $friends = $result['friends'];
    $fids = explode(",", $friends);
    foreach($fids as $fid) {
            if ($fid == $target) $true = 1;  }
    if ($true != 1) {
            if ($target == $id) echo "You can't friend yourself.";
            else {
                    if ($friends == "") $friends .= $target; 
                    else $friends .= ','.$target;
                    $data['friends'] = $friends;
                    $where = 'id = '.$db->escape($id);
                    $sql = $db->update('users',$data,$where);
                    echo 'Friend added.';
            }
    }
            else echo 'You already friend with this player.';
}

?>