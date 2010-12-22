<?php

require_once('includes/functions/rating.php');
require_once('includes/functions/friends.php');
require_once('includes/functions/steamcomm.php');
require_once('includes/functions/etf2l.php');

function displayID($steamid) {
	$sql =  'SELECT * FROM users WHERE steamid= \'' . mysql_real_escape_string($steamid) . '\' LIMIT 1';
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	return $result['id'];
}

function displaySteamID($id) {
	$sql =  'SELECT * FROM users WHERE id= \'' . mysql_real_escape_string($id) . '\' LIMIT 1';
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	return $result['steamid'];
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
	
	public function __construct($id) {
	$query =  'SELECT * FROM users WHERE id= \'' . mysql_real_escape_string($id) . '\' LIMIT 1';

	$result = mysql_query($query);
	$userinfo = mysql_fetch_assoc($result);
		
	$this->id		= $userinfo['id'];
	$this->nickname = $userinfo['nickname'];
	$this->steamid  = $userinfo['steamid'];
	$this->steamid = $userinfo['steamid'];
	$this->rating 	= rating($this->id);
	$this->avatar 	= APIGet($this->steamid,avatar);
	$this->etf2lid = str_replace(steam, "", GetAuthID($this->steamid));
		
	}
	
	public function profileuser($id) {	
	return  '
	            <div class="profile_panel">
                <h1>User Info</h1>
                <span class="user_name">'.$this->nickname.'</span><br />
                <span class="user_steamid">'.GetAuthID($this->steamid).'</span>
                <dl>
                    <dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/demo.png" height="14"><span style="float: left; margin-left: 3px;">Demoman</span></dd>
                    <dt>Skilllevel:</dt><dd>Division '.etf2ldiv($this->etf2lid).'</dd>
                    <dt>Rating:</dt><dd>'.$this->rating.'</dd>
                </dl>
            </div>';
	}
	
	public function mainuser($id) {
	
	return '
					<h1>User Info</h1>
				<img src='. $this->avatar .' width="32" height="32"></img>
				<span class="user_name">'. $this->nickname. '</span>
				<span class="user_steamid">'. GetAuthID($this->steamid) .'</span>
				<dl>
					<dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/demo.png" height="14"><span style="float: left; margin-left: 3px;">Demoman</span></dd>
					<dt>Skilllevel:</dt><dd>Division 4</dd>
					<dt>Rating:</dt><dd>'. $this->rating . '</dd>
				</dl>';
	}
		
	
}
$user = new user($_SESSION['id']);

lastseen($_SESSION['id']);

?>