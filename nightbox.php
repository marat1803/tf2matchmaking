<?php

require_once 'includes/header.php';
require_once 'includes/functions/rating.php';


if (isset($_GET[openid_claimed_id])) {
	$steamid = basename($_GET[openid_claimed_id]);
	$result = mysql_query("SELECT * FROM users WHERE steamid = ".$steamid) or die ("Error in query: $result. ".mysql_error());
	$row = mysql_fetch_row($result);

	$openidlink = "<a href='https://steamcommunity.com/openid/login?openid.ns=http://specs.openid.net/auth/2.0&openid.mode=checkid_setup&openid.return_to=http://89.137.219.32/nightbox.php&openid.realm=http://89.137.219.32/nightbox.php&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.identity=http://specs.openid.net/auth/2.0/identifier_select'><img id='openid' src='http://steamcommunity.com/public/images/signinthroughsteam/sits_small.png' /></a>";

	if (isset($result) && ($steamid == $row[3]))
		{
				echo "Welcome " .$row[1], " ", $rating[0];
		}
				else echo "Need to register"; 
	}
		else echo $openidlink;
echo rating($rating[1]);

?>
<a href='https://steamcommunity.com/openid/login?openid.ns=http://specs.openid.net/auth/2.0&openid.mode=checkid_setup&openid.return_to=http://89.137.219.32/nightbox.php&openid.realm=http://89.137.219.32/nightbox.php&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.identity=http://specs.openid.net/auth/2.0/identifier_select'><img id='openid' src='http://steamcommunity.com/public/images/signinthroughsteam/sits_small.png' /></a>