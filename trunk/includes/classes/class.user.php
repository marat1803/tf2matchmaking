<?php
require_once('includes/functions/rating.php');
require_once('includes/functions/friends.php');
require_once('includes/functions/steamcomm.php');
require_once('includes/functions/etf2l.php');

class User
{
	public function __construct($id) 
	{
		$result = mysql_query("SELECT id, nickname, steamid FROM users WHERE id = '$id' LIMIT 1");
		$userinfo = mysql_fetch_assoc($result);

		$this->id = $userinfo['id'];
		$this->nickname = $userinfo['nickname'];
		$this->steamid = $userinfo['steamid'];
		$this->rating = rating($this->id);
		$this->avatar = APIGet($this->steamid,avatar);
		$this->etf2lid = str_replace('STEAM', '', GetAuthID($this->steamid));
	}

	public function display_profile($id, $full = true) 
	{
		if ($full)
			return '<h1>User Info</h1>
					<img src=' . $this->avatar . ' width="32" height="32"></img>
					<span class="user_name">' . $this->nickname . '</span>
					<span class="user_steamid">' . GetAuthID($this->steamid) . '</span>
					<dl>
						<dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/demo.png" height="14"><span style="float: left; margin-left: 3px;">Demoman</span></dd>
						<dt>Skilllevel:</dt><dd>Division 4</dd>
						<dt>Rating:</dt><dd>' . $this->rating . '</dd>
					</dl>';
		else
			return '<div class="profile_panel">
						<h1>User Info</h1>
						<span class="user_name">' . $this->nickname . '</span><br />
						<span class="user_steamid">' . GetAuthID($this->steamid) . '</span>
						<dl>
							<dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/demo.png" height="14"><span style="float: left; margin-left: 3px;">Demoman</span></dd>
							<dt>Skilllevel:</dt><dd>Division ' . etf2ldiv($this->etf2lid) . '</dd>
							<dt>Rating:</dt><dd>' . $this->rating . '</dd>
						</dl>
					</div>';
	}

	public static function get_id($steamid) 
	{
		$query = mysql_query("SELECT id FROM users WHERE steamid = '$steamid' LIMIT 1");
		$result = mysql_fetch_array($query);
		return $result['id'];
	}

	public static function get_steamid($id) 
	{
		$query = mysql_query("SELECT steamid FROM users WHERE id = '$id' LIMIT 1");
		$result = mysql_fetch_array($query);
		return $result['steamid'];
	}
}
?>