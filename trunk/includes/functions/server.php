<?php
/*
function isServerJoinable($id) {
	$sql = 'SELECT status FROM servers WHERE id = '.mysql_real_escape_string($id);
	$query = mysql_query($sql);
	$result = mysql_fetch_assoc($query);
	$status = $result['status'];
	if ($status == "online") return true;
	else return false;
}*/
function getOnlineServers() {
	$sql = 'SELECT * FROM servers WHERE status = "online"';
	$query = mysql_query($sql);
	while ($servers = mysql_fetch_array($query, MYSQL_ASSOC)) {
		if ($serverlist == "") $serverlist .= $servers['id'];
		else $serverlist .= ','.$servers['id'];
	}
	echo $serverlist;
}

?>