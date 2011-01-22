<?php

function displayChat($lobbyid) {
	$db = Database::obtain();
	$lobbyid = $db->escape($lobbyid);
	$sql = 'SELECT * FROM chat WHERE lobbyid = '.$lobbyid.' AND date >= NOW() - INTERVAL 5 SECOND';
	$results = $db->fetch_array($sql);
	$return = '';
	foreach ($results as $result) {
		$player = player($result['playerid']);
		$time = strtotime($result['date']);
		$return.= '<dt>'.$player['nickname'].':</dt><dd>'.$result['text'].'<span class="time">'.date("G:i",$time).'</span></dd>';
	}
	return $return;
}

function newMessage($id,$lobby,$message) {
	$db = Database::obtain();
	$data = array('playerid' => $id,
				  'lobbyid' => $lobby,
				  'text' => $message);
	$insert = $db->insert('chat',$data);
}

?>