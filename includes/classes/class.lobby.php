<?php

require_once('includes/functions/lobby.php');

class lobby {
	public $id;
	public $name;
	public $type;
	public $region;
	public $map;
	public $players_blu;
	public $players_red;
	public $rules;
	public $status;
	public $division;
	public $date;
	public $sid;

	public function __construct($id) {
		$db = Database::obtain();
		$sql = 'SELECT * FROM lobbies WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$lobbyinfo = $db->fetch($query);
		
		$this->id = $lobbyinfo['id'];
		$this->name = $lobbyinfo['name'];
		$this->type = $lobbyinfo['type'];
		$this->region = $lobbyinfo['region'];
		$this->map = $lobbyinfo['map'];
		$this->players_spec = displayLobbyPlayers($this->id,$this->type,0);
		$this->players_blu = displayLobbyPlayers($this->id,$this->type,1);
		$this->players_red = displayLobbyPlayers($this->id,$this->type,2);
		$this->rules = $lobbyinfo['rules'];
		$this->status = $lobbyinfo['status'];
		$this->division = $lobbyinfo['division'];
		$this->date = $lobbyinfo['date'];	
		$this->sid = $lobbyinfo['sid'];	
		$this->leader = $lobbyinfo['leader'];
	}

	public function lobbyinfo() {
		$info = array(
			'id' => $this->id,
			'name' => $this->name,
			'type' => $this->type,
			'region' => $this->ragion,
			'map' => $this->map,
			'division' => $this->division,
			'date' => $this->date,
			'status' => $this->status,
			'server' => $this->sid,
			'leader' => $this->leader
			);
		return $info;
	}

	public function lobbyLeader() {
		return $this->leader;
	}

	public function lobbytype($id) {
		if(!$id || $id == $this->id) {
			return $this->type;
		}
		$db = Database::obtain();
		$sql = 'SELECT * FROM lobbies WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$lobbyinfo = $db->fetch($query);
		return $lobbyinfo['type'];		
	}

	public function lobbystatus($id) {
		if(!$id || $id == $this->id) {
			return $this->status;
		}
		$db = Database::obtain();
		$sql = 'SELECT * FROM lobbies WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$lobbyinfo = $db->fetch($query);
		return $lobbyinfo['status'];	
	}
	
	public function lobbyserver($id) {
		if(!$id || $id == $this->id) {
			return $this->sid;
		}
		$db = Database::obtain();
		$sql = 'SELECT * FROM lobbies WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$lobbyinfo = $db->fetch($query);
		return $lobbyinfo['sid'];	
	}

	public function displaylobbyplayers($id) {	
	echo $this->players_blu;
	echo '<br />';
	echo $this->players_red;	
	}

	public function lobbyData() {
		$data = array(
			'blu'  => grabLobbyPlayers($this->id, $this->type, 1),
			'red'  => grabLobbyPlayers($this->id, $this->type, 2),
			'spec' => grabLobbyPlayers($this->id, $this->type, 0),
			'size' => teamplayers($this->type),
		);
		return $data;
	}
}


function displayLobby($id,$full = false,$ready = false, $rate = false) {
	$lobby = new lobby($id);
	$sid = $lobby->lobbyserver($id);
	$server = new Server($sid);
	echo '<li class="lobby_panel" data-panel="lobby_tooltip-'.$lobby->id.'">
			<img class="map_pic" src="theme/images/maps/' .$lobby->map .'.jpg">
			<div class="panel_left">
				<h1>' .$lobby->name .'</h1>
				<span class="date">'.date('g:i a', strtotime($lobby->date)).'</span>
				<span class="map">' .$lobby->map .'</span>
				<ul class="classes">
					<li><img src="theme/images/class/scout.png" height="18"></li>
					<li><img src="theme/images/class/soldier.png" height="18"></li>
					<li><img src="theme/images/class/demo.png" height="18"></li>
					<li><img src="theme/images/class/heavy.png" height="18"></li>
					<li><img src="theme/images/class/sniper.png" height="18"></li>					
					<li><img src="theme/images/class/medic.png" height="18"></li>
				</ul>
			</div>
			<div class="panel_right">
						<span class="skillevel skill_higher">Division '.$lobby->division .'</span>
						<span class="matchtype">' .type($lobby->type) .'</span>
						<span class="playercount"><span class="currentplayers">'.countPlayers($lobby->id).'</span>/<span class="maxplayers">'. 2*(teamplayers($lobby->type)).'</span></span>
			</div>
			</li>';
			if ($full) echo '<li class="lobby_tooltip_big" id="lobby_tooltip:'.$lobby->id.'">';
			else echo '<li class="lobby_tooltip" id="lobby_tooltip:'.$lobby->id.'">';
			echo '
			<ul class="blue_players">
				<li class="teamname blu">BLU</li>';
				if (!$ready && !$rate) $lobby->players_blu;
				if ($ready && !$rate) echo displayLobbyPlayers($lobby->id,$lobby->type,1,true,false);
				if (!$ready && $rate) echo displayLobbyPlayers($lobby->id,$lobby->type,1,false,true);
					echo '
			</ul>
			<ul class="red_players">
				<li class="teamname red">RED</li>';
				if (!$ready && !$rate) $lobby->players_red;
				if ($ready && !$rate) echo displayLobbyPlayers($lobby->id,$lobby->type,2,true,false);
				if (!$ready && $rate) echo displayLobbyPlayers($lobby->id,$lobby->type,2,false,true);
				echo '
			</ul>';
			if ($full) echo '
			<h1 style="margin-top: 10px;  margin-right: 5px;">Spectators:</h1>
			<ul class="spec_players" style="margin-top: 10px; float: left;">'.$lobby->players_spec.'
			</ul><h1 style="margin-top: 10px;  margin-right: 5px; clear: left;">Info:</h1>
					<ul style="margin-top: 10px; float: left;">
						<li>Lobby started at 14:23 and has now been running for <span class="time_run">13</span> minutes.</li>
					</ul>
		</li>';
			else echo '<div class="lobby_info">
						<h1>Gameserver</h1>
						'.$server->showServer().'
						<a href="lobby.php?id='.$lobby->id.'" class="button join">Join</a>
					</div>';
}

function displaylobbies($type) {	
	$db = Database::obtain();
	$query = 'SELECT * FROM lobbies WHERE status = "open" AND type = '.$db->escape($type);
	$result = $db->query($query);
	
	while ($lobbyinfo = $db->fetch($result)) {
		$id = $lobbyinfo['id'];
		displayLobby($id);
	}
}



	

?>