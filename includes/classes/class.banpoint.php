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
	$pointsvalue = array('noshow' => 5,
						 'noshowvoice' => 3,
						 'ragequit' => 5,
						 'afk' => 3,
						 'noob' => 4,
						 'offclass' => 4,
						 'micspam' => 3,
						 'exploit' => 4,
						 'swearing' => 3,
						 'racism' => 20,
						 'cheating' => 500,
						 );
	if ($offence != 'custom') $points = $pointsvalue[$offence];
	$data = array('playerid' => $player,
				  'lobbyid'  => $lobby,
				  'admin'    => $admin,
				  'offence'  => $offence,
				  'points'   => $points,
				  'comment'  => $comment);
	$db->insert('banpoints',$data);
	$user['banpoints'] = 'INCREMENT('.$points.')';
	$where = 'id = '.$db->escape($player);
	$db->update('users',$user,$where);
	return 'Succesfully added ban points';
}





?>