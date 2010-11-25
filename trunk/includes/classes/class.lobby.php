<?php

require_once('includes/functions/lobby.php');

class lobby {
	public $id;
	public $name;
	public $region;
	public $players_blu;
	public $players_red;
	public $rules;
	public $status;
	public $date;
	
	public function displaylobby($id) {
	global $user;
	if(isset($_POST['lobbyId']) && $_POST['lobbyId']) {
		
		$query = 'INSERT INTO  `lobby_players` (`playerid` ,`lobbyID`) VALUES(' . $user->id . ' ,' . $_POST['lobbyId'] . ')';
		mysql_query($query) or die('Failed to add player to lobby.');
		return;
	}
	$query = 'SELECT * FROM lobbies WHERE status = 1  LIMIT 1';
	$result = mysql_query($query);
	$lobbyinfo = mysql_fetch_assoc($result);
	
	$this->id = $lobbyinfo['id'];
	$this->name = $lobbyinfo['name'];
	$this->type = $lobbyinfo['type'];
	$this->region = $lobbyinfo['region'];
	$this->map = $lobbyinfo['map'];
	$this->players_blu = displayLobbyPlayers($this->id,1);
	$this->players_red = displayLobbyPlayers($this->id,2);
	$this->rules = $lobbyinfo['rules'];
	$this->status = $lobbyinfo['status'];
	$this->date = $lobbyinfo['date'];
	
//	for ($i=1; $i<=5; $i++) {
		echo '<li class="lobby_panel" id="lobbyid:1">
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
								<span class="skillevel skill_higher">Division 2</span>
								<span class="matchtype">' .type($this->type) .'</span>
								<span class="playercount"><span class="currentplayers">'.countPlayers($this->id).'</span>/<span class="maxplayers">'. 2*(teamplayers($this->type)).'</span></span>
					</div>
						<li id="lobby_tooltip">
					<ul class="blue_players">
						<li class="teamname blu">BLU</li>
						'.$this->players_blu .'
					</ul>
					<ul class="red_players">
						<li class="teamname red">RED</li>
						'.$this->players_red .'
					</ul>
					<form action="" method="post">
					<button name="lobbyId" value="' . $this->id . '"></button>
					</form>
				</li>';
//	}				
	}
	
}	

$lobby = new lobby();
	

?>