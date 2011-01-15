<?php

require_once 'class.rcon.php';

class server {
	public $id;
	public $name;
	public $ip;
	public $port;
	public $password;
	public $location;
	public $status;

	public function __construct($id) {
		if(isset($id)) {
			$this->getServer($id);
		}
	}

	public function getServer($id) {
		$db = Database::obtain();
		$sql = 'SELECT * FROM servers WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$result = $db->fetch($query);
		$this->id = $result['id'];
		$this->name = $result['name'];
		$this->ip = $result['ip'];
		$this->port = $result['port'];
		$this->rcon = $result['rcon'];
		$this->password = $result['password'];
		$this->latitude = $result['latitude'];
		$this->longitude = $result['longitude'];
		$this->status = $result['status'];
	}

	public function showServer() {
		return '
		<dl>
					<dt>Name:</dt><dd>'.$this->name.'</dd>
					<dt>IP:</dt><dd>'.$this->ip.'</dd>
					<dt>Location:</dt><dd>'.city($this->latitude,$this->longitude).'</dd>
					<dt>Rules:</dt><dd>ETF2L 6 vs. 6</dd>	
				</dl>
			<h1>Mumble</h1>
					<dl>
						<dt>Name:</dt><dd>Test Server</dd>
						<dt>IP:</dt><dd>127.0.0.1</dd>
					</dl>	';
	}

	function isServerJoinable($id) {/*
		$sql = 'SELECT status FROM servers WHERE id = '.$db->escape($id);
		$query = $db->query($sql);
		$result = $db->fetch($query);
		$status = $result['status'];*/
		//return ($this->status == "online");
		if ($status == "online") return true;
		else return false;
	}


	public function loadConfig($players,$config,$map) {
		$server = $this->ip;
		$port = $this->port;
		$rcon = $this->rcon;
		$players = $players/2;
		$srcds_rcon = new srcds_rcon();
		$getconfig = file_get_contents('configs/'.$players.'vs'.$players.'/'.$config.'.cfg');
		$commands = explode("\n", $getconfig);
		$srcds_rcon->rcon_command($server,$port,$rcon, 'changelevel '.$map);
		sleep(20);
		foreach ($commands as $command) {
			$srcds_rcon->rcon_command($server, $port, $rcon, $command);
		}
	}

	function joinServer() {
		$server = new server($this->id);
		if ($this->isServerJoinable($this->id)) {
			echo '<a href="' . $server->getUrl() . '">Join server</a>';
		}
	}


	public function getUrl() {
		return 'steam://connect/' . $this->ip
			. ($this->port ? ':' . $this->port : '')
			. ($this->password ? '/' . $this->password : '');
	}

}

require_once('includes/functions/server.php');

?>