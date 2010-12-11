<?php

class server {
	public $id;
	public $ip;
	public $port;
	public $password;
	public $location;
	public $status;

	public function __construct($id) {
		if($id) {
			$this->getServer($id);
		}
	}

	public function getServer($id) {
		$sql = 'SELECT * FROM servers WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$result = mysql_fetch_assoc($query);
		$this->id = $result['id'];
		$this->ip = $result['ip'];
		$this->port = $result['port'];
		$this->password = $result['password'];
		$this->location = $result['location'];
		$this->status = $result['status'];
	}

	function isServerJoinable($id) {/*
		$sql = 'SELECT status FROM servers WHERE id = '.mysql_real_escape_string($id);
		$query = mysql_query($sql);
		$result = mysql_fetch_assoc($query);
		$status = $result['status'];*/
		return ($this->status == "online");
		/*if ($status == "online") return true;
		else return false;*/
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