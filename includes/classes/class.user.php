<?php

require_once('includes/functions/rating.php');
require_once('includes/functions/friends.php');
require_once('includes/functions/steamcomm.php');

function displayID($steamid) {
	$sql =  'SELECT * FROM users WHERE steamid= \'' . $steamid . '\' LIMIT 1';
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	return $result['id'];
}


class user {
	public $id;
	public $nickname;
	public $avatar;
	public $email;
	public $steamid;
	public $regdate;
	public $rating;
	public $skill;
	
	
	public function profileuser($id) {
	
	$query =  'SELECT * FROM users WHERE id= \'' . mysql_real_escape_string($id) . '\' LIMIT 1';

	$result = mysql_query($query);
	$userinfo = mysql_fetch_array($result);
		
	$this->id		= $userinfo['id'];
	$this->nickname = $userinfo['nickname'];
	$this->steamid  = $userinfo['steamid'];
	$this->rating 	= rating($this->id);
	$this->avatar 	= getAvatar($this->steamid);
	
	echo $this->nickname .'<br />'.GetAuthID($this->steamid).'<br />'.$this->rating; 
	}
	
	public function mainuser($id) {
	
	$query =  'SELECT * FROM users WHERE id= \'' . mysql_real_escape_string($id) . '\' LIMIT 1';

	$result = mysql_query($query);
	$userinfo = mysql_fetch_array($result);
		
	$this->id		= $userinfo['id'];
	$this->nickname = $userinfo['nickname'];
	$this->steamid  = $userinfo['steamid'];
	$this->rating 	= rating($this->id);
	$this->avatar 	= getAvatar($this->steamid);
	
	echo '
					<h1>User Info</h1>
				<img src='. $this->avatar .'></img>
				<span class="user_name">'. $this->nickname. '</span>
				<span class="user_steamid">'. GetAuthID($this->steamid) .'</span>
				<dl>
					<dt>Mainclass:</dt><dd>Demoman <img class="class_icon" src="theme/images/class/demo.png" height="10"></dd>
					<dt>Skilllevel:</dt><dd>Division 4</dd>
					<dt>Rating:</dt><dd>'. $this->rating . '</dd>
				</dl>';
	}
	
	
	/*if(isset($_SESSION['steamid']) && $_SESSION['steamid']) {
	$query =  'SELECT * FROM users WHERE steamid = \'' . mysql_real_escape_string($_SESSION['steamid']) . '\' LIMIT 1';
	$result = mysql_query($query);
	$userinfo = mysql_fetch_assoc($result);

	$user = new user();
	
	
	$user->id		= $userinfo['id'];
	$user->nickname = $userinfo['nickname'];
	$user->email    = $userinfo['email'];
	$user->steamid  = $userinfo['steamid'];
	$user->friends = $userinfo['friends'];
	$user->banpoints = $userinfo['banpoints'];
	$user->regdate  = $userinfo['regdate'];
	$user->rating 	= rating($user->id);
	
	$avatar = getAvatar($steamid);
	$steamid = $user->steamid;
	
*/
	
}
$user = new user();
?>