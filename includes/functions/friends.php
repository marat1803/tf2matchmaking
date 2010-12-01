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

function getfriends ($id,$fids) {
$fidsar = explode(",", $fids);
$curuser=0;
foreach($fidsar as $fid) {
$query = 'SELECT * FROM users WHERE id=' . $fid;
$result = mysql_query($query);
$friendsinfo = mysql_fetch_assoc($result);
$fid = $friendsinfo['nickname'];
$steamid = $friendsinfo['steamid'];
$avatar = APIGet($steamid,avatar);
$cleanid = GetAuthID($steamid);
$status = getStatus($id);
$return[$curuser] = '<li>
<img src='.$avatar.'></img>'.
'<span class="user_name">'.$fid.'</span>'.
'<span class="user_steamid">'.$cleanid.'</span>'.
'<span class="user_steamon">'.$status.'</span><br />
</li>';
$curuser=$curuser+1;
}
return $return;
}

function queryfr($id) {
$query = 'SELECT friends FROM users WHERE id='.$id;
$result = mysql_query($query);
$friendsinfo = mysql_fetch_assoc($result);
$fids = $friendsinfo['friends'];
$return=getfriends ($id,$fids);
return $return;
}


?>