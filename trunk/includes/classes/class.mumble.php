<?php

class Mumble extends Server {


	public function __construct($id) {
		if(id) {
			$db = Database::obtain();
			$sql = 'SELECT * FROM mumble WHERE id = '.$db->escape($id);
			$query = $db->query($sql);
			$result = $db->fetch($query);
			$this->id = $result['id'];
			$this->name = $result['name'];
			$this->ip = $result['ip'];
			$this->port = $result['port'];
			$this->password = $result['password'];
		}
	}

	public function getUrl() {
		return 'mumble://' . $this->ip
			. ($this->port ? ':' . $this->port : '');
	}

	public function showServer() {
		return '
			<h1>Mumble</h1>
					<dl>
						<dt>Name:</dt><dd>'.$this->name.'</dd>
						<dt>IP:</dt><dd><a href='.$this->getUrl().'>'.$this->ip.'</a></dd>
					</dl>	';
	}
}

?>