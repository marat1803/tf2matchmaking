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

	public function lobbytype($id) {
		$sql = 'SELECT * FROM lobbies WHERE id = '.$id;
		$query = mysql_query($sql);
		$lobbyinfo = mysql_fetch_assoc($query);
		return $lobbyinfo['type'];
		
	}
	
	public function displaylobbies($type) {
	global $user;
	
	$query = 'SELECT * FROM lobbies WHERE status = "open" AND type = '.$type;
	$result = mysql_query($query);
	
	while ($lobbyinfo = mysql_fetch_assoc($result)) {
		
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
	
		echo '<li class="lobby_panel" data-panel="lobby_tooltip-'.$this->id.'">
					<img class="map_pic" src="theme/images/maps/' .$this->map .'.jpg">
					<div class="panel_left">
						<h1>' .$this->name .'</h1>
						<span class="date">'.date('g:i a', strtotime($this->date)).'</span>
						<span class="map">' .$this->map .'</span>
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
								<span class="skillevel skill_higher">Division '.$this->division .'</span>
								<span class="matchtype">' .type($this->type) .'</span>
								<span class="playercount"><span class="currentplayers">'.countPlayers($this->id).'</span>/<span class="maxplayers">'. 2*(teamplayers($this->type)).'</span></span>
					</div>
						<li class="lobby_tooltip" id="lobby_tooltip:'.$this->id.'">
					<ul class="blue_players">
						<li class="teamname blu">BLU</li>
						'.$this->players_blu .'
					</ul>
					<ul class="red_players">
						<li class="teamname red">RED</li>
						'.$this->players_red .'
					</ul>
					<form action="lobby.php" method="get">
					<button name="id" value="' . $this->id . '">Join Lobby</button>
					</form>
				</li>';
		}
	
	}
}	

$lobby = new lobby();

function displaylobby($id) {	
	$sql = 'SELECT * FROM lobbies WHERE id = '.$id;
	$query = mysql_query($sql);
	$lobbyinfo = mysql_fetch_assoc($query);
	
	$lobby->id = $lobbyinfo['id'];
	$lobby->name = $lobbyinfo['name'];
	$lobby->type = $lobbyinfo['type'];
	$lobby->region = $lobbyinfo['region'];
	$lobby->map = $lobbyinfo['map'];
	$lobby->players_blu = displayLobbyPlayers($lobby->id,$lobby->type,1);
	$lobby->players_red = displayLobbyPlayers($lobby->id,$lobby->type,2);
	$lobby->rules = $lobbyinfo['rules'];
	$lobby->status = $lobbyinfo['status'];
	$lobby->division = $lobbyinfo['division'];
	$lobby->date = $lobbyinfo['date'];
	
	echo $lobby->players_blu;
	echo '<br />';
	echo $lobby->players_red;	
}
	

?>