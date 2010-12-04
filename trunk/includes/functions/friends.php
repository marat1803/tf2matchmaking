<?php

function getStatus ($id)
{
	$query = 'SELECT * FROM users WHERE id=' . $id;
	$result = mysql_query($query);
	$statuss = mysql_fetch_assoc($result);
	$status = $statuss['status'];
	if ($status == 1) return "Online";
	else return "Offline";
}

function getfriends ($id) {
	$query = 'SELECT friends FROM users WHERE id='.$id;
	$result = mysql_query($query);
	$friendsinfo = mysql_fetch_assoc($result);	
	$fids = $friendsinfo['friends'];
	if ($fids != "") {
	$fidsar = explode(",", $fids);
		foreach($fidsar as $fid) {
			$query = 'SELECT * FROM users WHERE id=' . $fid;
			$result = mysql_query($query);
			$friendsinfo = mysql_fetch_assoc($result);
			$fid = $friendsinfo['nickname'];
			$steamid = $friendsinfo['steamid'];
			if ($friendsinfo['status'] == 1) $status = '<li>';
				else $status = '<li class="friend_offline">';
			$return = $status.'
			<img src='.APIGet($steamid,avatar).'></img>'.
			'<span class="user_name">'.$fid.'</span>'.
			'<span class="user_steamid">'.GetAuthID($steamid).'</span>'.
			'<span class="user_steamon">'.getStatus($id).'</span><br />
			</li>';
			echo $return;
		}
	} else echo 'You have no friends yet';
	
}

function addFriend ($id,$target) {
	$sql = 'SELECT friends FROM users WHERE id = '.$id;
	$query = mysql_query($sql);
	$result = mysql_fetch_assoc($query);
	$friends = $result['friends'];
	$fids = explode(",", $friends);
	foreach($fids as $fid) {
		if ($fid == $target) $true = 1;  }
	if ($true != 1) {
	$friends .= ','.$target;
	$sql = "UPDATE users SET friends = '".$friends."' WHERE id = ".$id;
	$query = mysql_query($sql);
	}
		else echo 'You already friend with this player.';
}

?>