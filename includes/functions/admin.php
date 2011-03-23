<?php

function regUsers() {
	$db = Database::obtain();
	$sql = 'SELECT COUNT(*) FROM users';
	$query = $db->query_first($sql);
	return $query['COUNT(*)'];
}

function siteStats() {
	$return = '
		<tr><td><img src="theme/images/visitor.png"></td><td>Visitors</td><td>&nbsp;</td><td>1500</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; Today</td><td>&nbsp;</td><td>203</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; Week</td><td>&nbsp;</td><td>703</td></tr>
		<tr><td><img src="theme/images/star_silver.png"></td><td>Matches Played</td><td>&nbsp;</td><td>3000</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; 6v6</td><td>&nbsp;</td><td>403</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; Highlander</td><td>&nbsp;</td><td>703</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; Friends only</td><td>&nbsp;</td><td>600</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; PCW</td><td>&nbsp;</td><td>600</td></tr>
		<tr><td>&nbsp;</td><td>&raquo; League</td><td>&nbsp;</td><td>600</td></tr>
		<tr><td><img src="theme/images/user.png"></td><td>Registered Users</td><td>&nbsp;</td><td>'.regUsers().'</td></tr>';
	return $return;
}

function serversList() {
	$db = Database::obtain();
	$sql = 'SELECT * FROM servers ORDER BY status';
	$servers = $db->fetch_array($sql);
	$return = '';
	foreach ($servers as $server) {
		if ($server['status'] == 'online') $status = 'green';
		elseif ($server['status'] == 'taken') $status = 'yellow';
		else $status = 'red';
		$return .= '<tr><td><img src="theme/images/bullet_'.$status.'.png"></td><td>'.$server['name'].'</td><td>'.ucfirst($server['status'].'</td></tr>';
	}
	return $return;
}

function newUsers() {
	$db = Database::obtain();
	$sql = 'SELECT * FROM users ORDER BY id DESC LIMIT 5';
	$users = $db->fetch_array($sql);
	$return = '';
	foreach ($users as $user) {
		$return .= '<tr><td><img src="theme/images/bullet_green.png"></td><td>'.$user['nickname'].'</td><td>'.$user['id'].'</td><td><a href="admin.php?page=users&id='.$user['id'].'&action=delete"><img src="theme/images/bullet_cross.png"></a> <a href="admin.php?page=users&id='.$user['id'].'&action=lookup"><img src="theme/images/bullet_magnify.png"></a></td></tr>';
	}
	return $return;
}

?>