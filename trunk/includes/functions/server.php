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

?>