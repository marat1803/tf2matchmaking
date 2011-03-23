<?php


require_once 'includes/header.php';

$uid = $_SESSION['id'];
$lid = $_GET['id'];
$request = $_GET['request'];
$team = $_GET['team'];
$class = $_GET['class'];
$ready = $_GET['ready'];
$lat = $_GET['latitude'];
$lon = $_GET['longitude'];
$fid = $_GET['fid'];
$message = $_GET['message'];

if ($uid) $user = new User($uid);
if ($lid) $lobby = new Lobby($lid);
if ($uid && $lid) $id = getLPid($uid,$lid);

if ($uid && $lid) {
	switch ($request) {
		case "userready":
			$status = readystatus($id,true);
			$leader = $lobby->lobbyLeader();
			$array = array(
				'ready' => $status,
				'leader' => $leader);
			echo json_encode($array);
			break;
		case "changeTeam":
			if (isset($team) && freeslots($lid,$team) > 0) joinTeam($id, $team);
			break;
		case "switchClass":
			if (isset($class)) switchClass($id, $class);
			break;
		case "readystatus":
			if (isset($ready)) readystatus($id, false, $ready);
			break;
		case "startGame":
			$server =  new Server($lobby->lobbyserver($lid));
			if ($server->id == 1) {
				$location = getPlayersLocation($lid);
				$servers = getOnlineServers();
				$server = new Server(bestServer($location,$servers));
				updateLobbyServer($lid,$server->id);
			}
			startLobby($lid);	
			$players = teamplayers($lobby->type)*2;
			$server->loadConfig($players,etf2l,$lobby->map);
			break;
		case "joinGame":
			if (!isPlayerInLobby($uid) && countPlayers($lid) != 2*(teamplayers($lobby->type))) joinLobby($uid,$lid);
			if (isPlayerInLobby($uid) != $lid) echo '0';
			break;
		case "leaveLobby":
			if (isPlayerInLobby($uid) == $lid) leaveLobby($id);
			if ($lobby->leader == $uid && countPlayers($lid) == 0) deleteLobby($lid);
			break;
		case "showChat":
			echo displayChat($lid);
			break;
		case "newMessage":
			if ($message) echo newMessage($uid,$lid,$message);
			break;
	}
} 
if ($lid) {
	switch ($request) {
		case "lobbyinfo":
			$lobbyinfo = $lobby->lobbyinfo();
			$lobbyplayers = $lobby->lobbyData();
			$count = countPlayers($lid);
			updateLobbyReady($lid);
			if ($lobby->status == "ready") removeOfflinePlayers(checkOfflinePlayers($lid));
			$array = array(
				'id' => $uid,
				'ready' => readystatus($id,true),
				'inlobby' => isPlayerInLobby($uid),
				'info' => $lobbyinfo,
				'count' => $count,
				'players' => $lobbyplayers);
			echo json_encode($array);
			break;
		case "lobbyplayers":
			echo json_encode($lobby->lobbyData());
			break;
		case "distance":
			if ($lat && $lon) {
				$server = new Server($lobby->lobbyserver($lid));
				echo GetDistance($lat,$lon,$server->latitude,$server->longitude);
			}
			break;
		case "balanceTeams":
			$players = getPlayersSkill($lid);
			balanceTeams($lid,$players);
			break;

	}
} elseif ($uid) {
	switch ($request) {
		case "addFriend":
			if ($fid) addFriend($uid,$fid);
			break;
		case "newLobby":
			if (!isPlayerInLobby($uid)) {
				$name = $_POST['name'];
				$type = $_POST['type'];
				$address = $_POST['address'];
				$rcon = $_POST['rcon'];
				$address = explode(':',$address);
				$ip = gethostbyname($address[0]);
				$port = $address[1];
				$region = '';
				$map  = $_POST['map'];
				$division = '';
				if (isset($_POST['address'])) $sid = newServer($ip,$port,$rcon);
				else $sid = 1;
				$lastInsertId = newLobby($name,$type,$region,$map,$division,$uid,$sid);
				joinLobby($uid,$lastInsertId);
				if($lastInsertId) {
					echo $lastInsertId;
				}
			} else {
				echo '0';
			} break;
		case "rate":
			$lid    = $_POST['lid'];
			$id = getLPid($uid,$lid);
			$target = $_POST['userid'];
			$value  = $_POST['value'];
			rate($id, $target, $value);
			break;
	}
}