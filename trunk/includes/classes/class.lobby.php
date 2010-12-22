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
	}

	public function lobbytype($id) {
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['type'];		
	}

	public function lobbystatus($id) {
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['status'];	
	}
	
	public function lobbyserver($id) {
		$sql = 'SELECT * FROM lobbies WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['sid'];	
	}

	public function displaylobby($id) {	
	echo $this->players_blu;
	echo '<br />';
	echo $this->players_red;	
	}
}

function displaylobbies($type) {	
	$query = 'SELECT * FROM lobbies WHERE status = "open" AND type = '.mysql_real_escape_string($type);
	$result = mysql_query($query);
	mysql_error();
	
	while ($lobbyinfo = mysql_fetch_assoc($result)) {
		
	$id = $lobbyinfo['id'];
	$name = $lobbyinfo['name'];
	$type = $lobbyinfo['type'];
	$region = $lobbyinfo['region'];
	$map = $lobbyinfo['map'];
	$players_blu = displayLobbyPlayers($id,$type,1);
	$players_red = displayLobbyPlayers($id,$type,2);
	$status = $lobbyinfo['status'];
	$division = $lobbyinfo['division'];
	$date = $lobbyinfo['date'];
	
		echo '<li class="lobby_panel" data-panel="lobby_tooltip-'.$id.'">
					<img class="map_pic" src="theme/images/maps/' .$map .'.jpg">
					<div class="panel_left">
						<h1>' .$name .'</h1>
						<span class="date">'.date('g:i a', strtotime($date)).'</span>
						<span class="map">' .$map .'</span>
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
								<span class="skillevel skill_higher">Division '.$division .'</span>
								<span class="matchtype">' .type($type) .'</span>
								<span class="playercount"><span class="currentplayers">'.countPlayers($id).'</span>/<span class="maxplayers">'. 2*(teamplayers($type)).'</span></span>
					</div>
						<li class="lobby_tooltip" id="lobby_tooltip:'.$id.'">
					<ul class="blue_players">
						<li class="teamname blu">BLU</li>
						'.$players_blu .'
					</ul>
					<ul class="red_players">
						<li class="teamname red">RED</li>
						'.$players_red .'
					</ul>
					<form action="lobby.php" method="get">
					<button name="id" value="' . $id . '">Join Lobby</button>
					</form>
				</li>';
	}
}

	

?>