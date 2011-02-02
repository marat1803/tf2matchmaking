<?php

class banpoint {
	public function __construct($id) {
		$db = Database::obtain();
		$sql = 'SELECT * FROM banpoints WHERE id = '.$db->escape($id);
		$info = $db->query_first($sql);


		$this->id = $info['id'];
		$this->player = $info['playerid'];
		$this->lobby = $info['lobbyid'];
		$this->admin = $info['admin'];
		$this->offence = $info['offence'];
		$this->points = $info['points'];
		$this->comment = $info['comment'];
	}
}

function newBanPoints($player,$lobby,$admin,$offence,$points,$comment) {
	$db = Database::obtain();
	$data = array('playerid' => $player,
				  'lobbyid'  => $lobby,
				  'admin'    => $admin,
				  'offence'  => $offence,
				  'points'   => $points,
				  'comment'  => $comment);
	$db->insert('banpoints',$data);
	$user['banpoints'] = 'banpoints + '.$points;
	$where = 'id = '.$db->escape($player);
	$db->update('users',$user,$where);
}





?>