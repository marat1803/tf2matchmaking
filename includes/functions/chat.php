<?php

function displayChat($lobbyid) {
	$db = Database::obtain();
	$lobbyid = $db->escape($lobbyid);
	$sql = 'SELECT * FROM chat WHERE lobbyid = '.$lobbyid;
	$query = $db->query($sql);
	$results = $db->fetch_array($query);
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
	$data = array('id' => $id,
				  'lobbyid' => $lobby,
				  'text' => $message,
				  'date' => date('Y-m-d H:i:s'));
	$insert = $db->insert('chat',$data);
}

?>