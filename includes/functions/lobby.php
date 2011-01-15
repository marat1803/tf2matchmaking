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
	$db = Database::obtain();
	$sql = "SELECT * FROM users WHERE `id` = '".$db->escape($playerID)."' LIMIT 1";
	$res = $db->query($sql) or die(mysql_error());
	$row = $db->fetch($res);
	return $row;
}

function grabLobbyPlayers($lobbyID, $lobbytype, $team) {
	$db = Database::obtain();
	$sql = "SELECT * FROM lobby_players WHERE `lobbyID` = '".$db->escape($lobbyID)."' AND `team` = '".$team."'"; 
	$res = $db->query($sql) or die(mysql_error());
	$data = array();
	while ($row = $db->fetch($res)) {
		$player = player($row["playerid"]);
		$steamid = $player["steamid"];
		$avatar = APIGet($steamid,avatar);
		$class = player_class($row["class"]);
		$data[] = array(
			'id'       => $player['id'],
			'class'    => $class,
			'nickname' => $player['nickname'],
			'ready'    => readystatus($player['id'],true),
			'avatar'   => $avatar
		);
	}
	return $data;
}

function displayLobbyPlayers($lobbyID, $lobbytype, $team,$ready = false, $rate = false) {
	global $user;
	$uid = $user->id;
	$lobbyPlayers = grabLobbyPlayers($lobbyID, $lobbytype, $team);
	$display = '';
	if ($team != 0) {
		foreach ($lobbyPlayers as $data) {
			if (!$ready && !$rate) $display .= '<li><a href="profile.php?id='.$data['id'].'" target="_blank">
			<img src="theme/images/class/'.$data['class'].'.png" height="18">'.$data["nickname"].'
			<img class="avatar" src='.$data['avatar'].'></a></li>';
			if ($ready) $display = '<li class="ready"><li><a href="profile.php?id='.$data['id'].'" target="_blank">
			<img src="theme/images/class/'.$data['class'].'.png" height="18">'.$data["nickname"].'
			<img class="avatar" src='.$data['avatar'].'></a></li></li>';
			if ($rate)  $display .= '<li><a href="profile.php?id='.$data['id'].'" target="_blank">
			<img src="theme/images/class/'.$data['class'].'.png" height="18">'.$data["nickname"].'
			<img class="avatar" src='.$data['avatar'].'></a>'
			.($uid != $data['id'] ? '<span class="rate_switch"><a href="#rate_up:userid" class="rate_up" data-id="'.$data['id'].'">+</a><a "#rate_down:userid" class="rate_down" data-id="'.$data['id'].'">-</a></span>' : '')
			.'</li>';
			$n++;
		}
		for($n; $n < teamplayers($lobbytype); $n++) {
			$display .= '<li class="empty"><img src="theme/images/class/noclass.png" height="18">empty</li>';
		}
	} else {
		foreach ($lobbyPlayers as $data) {
			if ($display == "")	$display .= $data['nickname'];
			else $display .= ', '.$data['nickname'];
		}
	}
	return $display;
}


function countPlayers($lobbyid) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM lobby_players WHERE lobbyid = '.$db->escape($lobbyid);
	$res = $db->query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function countLobbies($status) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM lobbies WHERE status = "'.$db->escape($status).'"';
	$res = $db->query($sql);
	$count = mysql_num_rows($res);
	return $count;
}

function countTeamPlayers($lid,$team) {
	$db = Database::obtain();
	$sql = 'SELECT COUNT(*) AS `count` FROM lobby_players WHERE lobbyID = '.$db->escape($lid).' AND team = '.$db->escape($team);
	$query = $db->query($sql);
	$row = mysql_fetch_row($query);
	return $row[0];
}

function getLPid($pid,$lid) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM lobby_players WHERE playerid = '.$db->escape($pid).' AND lobbyid = '.$db->escape($lid);
	$query = $db->query($sql);
	$id = $db->fetch($query);
	return $id['id'];
}

function newLobby($name,$type,$region,$map,$division,$leader, $sid) {
	$db = Database::obtain();
	//$sql = 'INSERT INTO lobbies (name, type, region, map, division) VALUES ("'.$db->escape($name).'", "'.$db->escape($type).'", "'.$db->escape($region).'", "'.$db->escape($map).'", "'.$db->escape($division).'")';
	$data = array(
		'name'     => $name,
		'type'     => $type,
		'region'   => $region,
		'map'      => $map,
		'division' => $division,
		'leader'   => $leader,
		'sid'      => $sid,
	);
	$lastInsertId = $db->insert('lobbies', $data);

	//$lastInsertId = $db->query($sql);
	return $lastInsertId;
}

function joinLobby($id,$lid) {
	$db = Database::obtain();
	$sql = 'INSERT INTO lobby_players (playerid, lobbyID) VALUES('.$db->escape($id).', '.$db->escape($lid).')';
	$query = $db->query($sql);
}

function leaveLobby($id) {
	$db = Database::obtain();
	$sql = 'DELETE FROM lobby_players WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
}

function joinTeam($id,$team) {
	$db = Database::obtain();
	$sql = 'UPDATE lobby_players SET team = '.$db->escape($team).' WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
}

function switchClass($id,$class) {
	$db = Database::obtain();
	$sql = 'UPDATE lobby_players SET class = '.$db->escape($class).' WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
}

function readystatus($id,$show,$ready = false) {
	$db = Database::obtain();
	if(!$id) return false;
	if ($ready == 1 && !$show) {
		$sql = 'UPDATE lobby_players SET ready = "1" WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
	} elseif ($ready == 0 && !$show) {
		$sql = 'UPDATE lobby_players SET ready = "0" WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
	}
	if ($show) {
		$sql = 'SELECT * FROM lobby_players WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$result = $db->fetch($query);
		return $result['ready'];	
	}
}

function freeslots($id,$team) {
	$lobby = new Lobby($id);
	$lobbyType = $lobby->type;
	$playerCount = countTeamPlayers($id, $team);
	$maxPlayers = teamPlayers($lobbyType);
	return $maxPlayers - $playerCount;
}

function startLobby($id) {
	$db = Database::obtain();
	$sql = 'UPDATE lobbies SET status = "ingame" WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
}

function isPlayerInLobby($id) {
	$db = Database::obtain();
	$sql = "
	SELECT l.id FROM lobby_players AS `lp`
	LEFT JOIN lobbies AS `l`
	ON l.id = lp.lobbyID
	WHERE l.status != 'ingame' AND lp.playerid = ".$db->escape($id)."
	GROUP BY lp.playerid;
	"; //change ingame to closed when you can close a lobby
	$query = $db->query($sql);
	$row = $db->fetch($query);
	if($row) {
		return $row['id'];
	} else {
		return null;
	}
}

function changeLobby ($id,$setting,$into) {
	$db = Database::obtain();
	$sql = "UPDATE lobbies SET `".$setting."` = '".$into. "' WHERE id = ".$db->escape($id);
	$query = $db->query($sql);
}
?>