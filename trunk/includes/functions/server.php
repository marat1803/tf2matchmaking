<?php
/*
function isServerJoinable($id) {
	$sql = 'SELECT status FROM servers WHERE id = '.$db->escape($id);
	$query = $db->query($sql);
	$result = $db->fetch($query);
	$status = $result['status'];
	if ($status == "online") return true;
	else return false;
}*/
function getOnlineServers() {
	$db = Database::obtain();
	$sql = 'SELECT * FROM servers WHERE status = "online"';
	$query = $db->query($sql);
	while ($servers = mysql_fetch_array($query, MYSQL_ASSOC)) {
		if ($serverlist == "") $serverlist .= $servers['id'];
		else $serverlist .= ','.$servers['id'];
	}
	echo $serverlist;
}


function bestServer($latitude,$longitude,$server) {
	for ($k=0;$k<count($server);$k++) {
		for ($i=0;$i<count($latitude);$i++){
			$sum = $sum + getDistance($latitude[$i],$longitude[$i],$server[$k]['latitude'],$server[$k]['longitude']);
			if ($sum <= $min) {
				$min = $sum;
				$id = $k;
			}
		}
	}
	return $id;
}

function city($latitude,$longitude) {
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=false";
	$file = file_get_contents($url);
	$api = json_decode($file);
	foreach($api->results[0]->address_components as $city) {
		if ($city->types[0] == "locality") {
			return $city->short_name;
		}
	}
}

function loadConfig($server,$port,$rcon,$players,$config) {
	$players = $players/2;
	$srcds_rcon = new srcds_rcon();
	$getconfig = file_get_contents('configs/'.$players.'vs'.$players.'/'.$config.'.cfg');
	$commands = explode("\n", $getconfig);
	foreach ($commands as $command) {
		$srcds_rcon->rcon_command($server, $port, $rcon, $command);
	}
}



?>