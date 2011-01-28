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
	$return_array = array();
	foreach ($servers as $server) {
		$return = array();
		$return['id'] = $server['id'];
		$return['latitude'] = $server['latitude'];
		$return['longitude'] = $server['longitude'];
		$return_array[] = $return;
	}
	return $return_array;
}

function newServer($ip,$port,$rcon) {
	$db = Database::obtain();
	$file = simplexml_load_file('http://api.ipinfodb.com/v2/ip_query.php?key=ca24e42293944a1bff78a2e8833baefb68fa34e2cb997c0becc7aaf4208a7706&ip='.$ip);
	$latitude = $file->Latitude;
	$longitude = $file->Longitude;
	$srcds_rcon = new srcds_rcon();
	$hostname = $srcds_rcon->rcon_command($ip,$port,$rcon, 'hostname');
	$replace = array('"hostname" = "','" ( def. "" )
          - Hostname for server.');
	$hostname = str_replace($replace,'',$hostname);
	$password = $srcds_rcon->rcon_command($ip,$port,$rcon, 'sv_password');
	$replace = array('"sv_password" = "','" ( def. "" )
 notify
 - Server password for entry into multiplayer games');
	$password = str_replace($replace,'',$password);
	$data = array('name' => $hostname,
				  'ip' => $ip,
				  'port' => $port,
				  'rcon' => $rcon,
				  'password' => $password,
				  'latitude' => $latitude,
				  'longitude' => $longitude);
	$insert = $db->insert('servers',$data);
	return $insert;
}


function bestServer2($latitude,$longitude,$server) {
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

function bestServer($location,$server) {

	foreach($server as $k => $s){
		foreach($location as $i => $loc) { 
			$sum = $sum + getDistance($loc['latitutde'],$loc['longitude'],$s['latitude'],$s['longitude']);
			if ($sum <= $min || !$min) {
				$min = $sum;
				$id = $s['id'];
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