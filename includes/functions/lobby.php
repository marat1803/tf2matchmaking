<?php

function teamplayers($lobbytype) {
	switch ($lobbytype) {
		case 1:
		return 6;
		break;
		case 2:
		return 9;
		break;
	}
}

function type($lobbytype)
{
	switch (teamplayers($lobbytype)) {
		case 6:
		return "6vs6";
		break;
		case 9:
		return "Highlander";
		break;
	}
}

function lobbystatus($status)
{
	switch ($status) {
		case "open":
		return "Open";
		break;
		case "ready":
		return "Ready Phase";
		break;
		case "ingame":
		return "In Progress";
		break;
		case "finished":
		return "Finished";
		break;
		case "closed":
		return "Closed";
		break;
	}
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
	$sql = "SELECT * FROM users WHERE `id` = '".mysql_real_escape_string($playerID)."' LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	return $row;
}

function grabLobbyPlayers($lobbyID, $lobbytype, $team) {
	$sql = "SELECT * FROM lobby_players WHERE `lobbyID` = '".mysql_real_escape_string($lobbyID)."' AND `team` = '".$team."'"; 
	$res = mysql_query($sql) or die(mysql_error());
	$data = array();
	while ($row = mysql_fetch_assoc($res)) {
		$player = player($row["playerid"]);
		$steamid = $player["steamid"];
		$avatar = APIGet($steamid,avatar);
		$class = player_class($row["class"]);
		$data[] = array(
			'id'       => $player['id'],
			'class'    => $class,
			'nickname' => $player['nickname'],
			'avatar'   => $avatar
		);
	}
	return $data;
}

function displayLobbyPlayers($lobbyID, $lobbytype, $team) {
	$lobbyPlayers = grabLobbyPlayers($lobbyID, $lobbytype, $team);
	$display = '';
	foreach ($lobbyPlayers as $data) {
		$display .= '<li><a href="profile.php?id='.$data['id'].'" target="_blank"><img src="theme/images/class/'.$data['class'].'.png" height="18">'.$data["nickname"].'<img class="avatar" src='.$data['avatar'].' height="16"></a></li>';
		$n++;
	}
	for($n; $n < teamplayers($lobbytype); $n++) {
		$display .= '<li class="empty"><img src="theme/images/class/noclass.png" height="18">empty</li>';
	}
	return $display;
}


function countPlayers($lobbyid) {
	$sql = 'SELECT * FROM lobby_players WHERE lobbyid = '.mysql_real_escape_string($lobbyid);
	$res = mysql_query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function countLobbies($status) {
	$sql = 'SELECT * FROM lobbies WHERE status = "'.mysql_real_escape_string($status).'"';
	$res = mysql_query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function countTeamPlayers($lid,$team) {
	$sql = 'SELECT COUNT(*) AS `count` FROM lobby_players WHERE lobbyID = '.mysql_real_escape_string($lid).' AND team = '.mysql_real_escape_string($team);
	$query = mysql_query($sql);
	$row = mysql_fetch_row($query);
	return $row[0];
}

function getLPid($pid,$lid) {
	$sql = 'SELECT * FROM lobby_players WHERE playerid = '.mysql_real_escape_string($pid).' AND lobbyid = '.mysql_real_escape_string($lid);
	$query = mysql_query($sql);
	$id = mysql_fetch_assoc($query);
	return $id['id'];
}

function newLobby($name,$type,$region,$map,$division) {
	$sql = 'INSERT INTO lobbies (name, type, region, map, division) VALUES ('.mysql_real_escape_string($name).', '.mysql_real_escape_string($type).', '.mysql_real_escape_string($region).', '.mysql_real_escape_string($map).', '.mysql_real_escape_string($division);
	$query = mysql_query($sql);
}

function joinLobby($id,$lid) {
	$sql = 'INSERT INTO lobby_players (playerid, lobbyID) VALUES('.mysql_real_escape_string($id).', '.mysql_real_escape_string($lid).')';
	$query = mysql_query($sql);
}

function leaveLobby($id) {
	$sql = 'DELETE FROM lobby_players WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
}

function joinTeam($id,$team) {
	$sql = 'UPDATE lobby_players SET team = '.mysql_real_escape_string($team).' WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
}

function switchClass($id,$class) {
	$sql = 'UPDATE lobby_players SET class = '.mysql_real_escape_string($class).' WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
}

function readystatus($id,$ready = false) {
	if ($ready) {
		$sql = 'UPDATE lobby_players SET ready = "'.$ready.'" WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
	} else {
		$sql = 'SELECT * FROM lobby_players WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$result = mysql_fetch_assoc($query);
		return $result['ready'];		
	}
}

function freeslots($id,$team) {
	$lobbyType = Lobby::lobbyType($id);
	$playerCount = countTeamPlayers($id, $team);
	$maxPlayers = teamPlayers($lobbyType);//
	return $maxPlayers - $playerCount;
}

function startLobby($id) {
	$sql = 'UPDATE lobbies SET status = 1 WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
}

function isPlayerInLobby($id) {
	$sql = "
	SELECT l.id FROM lobby_players AS `lp`
	LEFT JOIN lobbies AS `l`
	ON l.id = lp.lobbyID
	WHERE l.status != 'closed' AND lp.playerid = ".mysql_real_escape_string($id)."
	GROUP BY lp.playerid;
	";
	$query = mysql_query($sql);
	$row = mysql_fetch_assoc($query);
	if($row) {
		return $row['id'];
	} else {
		return null;
	}
}

function changeLobby ($id,$setting,$into) {
	$sql = "UPDATE lobbies SET `".$setting."` = '".$into. "' WHERE id = ".mysql_real_escape_string($id);
	$query = mysql_query($sql);
}
?>