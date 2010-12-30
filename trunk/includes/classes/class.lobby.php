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
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		
		$this->id = $lobbyinfo['id'];
		$this->name = $lobbyinfo['name'];
		$this->type = $lobbyinfo['type'];
		$this->region = $lobbyinfo['region'];
		$this->map = $lobbyinfo['map'];
		$this->players_blu = displayLobbyPlayers($this->id,$this->type,1);
		$this->players_red = displayLobbyPlayers($this->id,$this->type,2);
		$this->rules = $lobbyinfo['rules'];
		$this->status = $lobbyinfo['status'];
		$this->division = $lobbyinfo['division'];
		$this->date = $lobbyinfo['date'];	
		$this->sid = $lobbyinfo['sid'];	
	}


	public function lobbytype($id) {
		if(!$id || $id == $this->id) {
			return $this->type;
		}
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['type'];		
	}

	public function lobbystatus($id) {
		if(!$id || $id == $this->id) {
			return $this->status;
		}
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['status'];	
	}
	
	public function lobbyserver($id) {
		if(!$id || $id == $this->id) {
			return $this->sid;
		}
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
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
			'size' => teamplayers($this->type),
		);
		return $data;
	}
}


function displayLobby($id) {
	$lobby = new lobby($id);
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
				<li class="lobby_tooltip" id="lobby_tooltip:'.$lobby->id.'">
			<ul class="blue_players">
				<li class="teamname blu">BLU</li>
				'.$lobby->players_blu .'
			</ul>
			<ul class="red_players">
				<li class="teamname red">RED</li>
				'.$lobby->players_red .'
			</ul>
		</li>';
}

function displaylobbies($type) {	
	$query = 'SELECT * FROM lobbies WHERE status = "open" AND type = '.mysql_real_escape_string($type);
	$result = mysql_query($query);
	
	while ($lobbyinfo = mysql_fetch_assoc($result)) {
		$id = $lobbyinfo['id'];
		displayLobby($id);
	}
}



	

?>