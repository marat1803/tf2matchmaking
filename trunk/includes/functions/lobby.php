<?php

function type($lobbytype)
{
if ($lobbytype == 1) return "6vs6";
if ($lobbytype == 2) return "Highlander";
}

function player_class($class)
{
	switch ($class) {
	case 0:
	return "noclass";
	break;
	case 1:
	return "scout";
	break;
	case 2:
	return "soldier";
	break;
	case 3:
	return "pyro";
	break;
	case 4:
	return "demo";
	break;
	case 5:
	return "heavy";
	break;
	case 6:
	return "engineer";
	break;
	case 7:
	return "medic";
	break;
	case 8:
	return "sniper";
	break;
	case 9:
	return "spy";
	break;
	}
}
function player($playerID) {
	$sql = "SELECT * FROM users WHERE `id` = '".$playerID."' LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	return $row;
}

function displayLobbyPlayers($lobbyID, $team) {
	$sql = "SELECT * FROM lobby_players WHERE `lobbyID` = '".$lobbyID."' AND `team` = '".$team."'"; 
	$res = mysql_query($sql) or die(mysql_error());
	$display = '';
		while ($row = mysql_fetch_assoc($res)) {
		$player = player($row["playerid"]);
		$steamid = $player["steamid"];
		$avatar = getAvatar($steamid);
		$class = player_class($row["class"]);
		$display .= '<li><img src="theme/images/class/'.$class.'.png" height="18">'.$player["nickname"].'<img class="avatar" src='.$avatar.' height="16"></li>';
		$n = $n+1;
		}
		for ($i=1;$i<=$n;$i++) {
			$x = (6 - $n);
			for ($y;$y<$x;$y++) {
				$display .= '<li class="empty"><img src="theme/images/class/noclass.png" height="18">empty</li>'; }
			}
	return $display;
}

function countPlayers($lobbyid) {
	$sql = 'SELECT * FROM lobby_players WHERE lobbyid = '.$lobbyid;
	$res = mysql_query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

?>