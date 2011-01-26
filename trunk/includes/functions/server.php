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
	$servers = $db->fetch_array($sql);
	foreach ($servers as $server) {
		$i = $server['id'];
		$return[$i] = $i;
	}
	return $return;
}

function newServer($ip,$port,$rcon) {
	$db = Database::obtain();
	$file = simplexml_load_file('http://api.ipinfodb.com/v2/ip_query.php?key=ca24e42293944a1bff78a2e8833baefb68fa34e2cb997c0becc7aaf4208a7706&ip='.$ip);
	$latitude = $file->Latitude;
	$longitude = $file->Longitude;
	$data = array('ip' => $ip,
				  'port' => $port,
				  'rcon' => $rcon,
				  'latitude' => $latitude,
				  'longitude' => $longitude);
	$insert = $db->insert('servers',$data);
	return $insert;
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