<?php
require_once('includes/functions/rating.php');
require_once('includes/functions/friends.php');
require_once('includes/functions/steamcomm.php');
require_once('includes/functions/etf2l.php');

function mainclass($id) {
	$db = Database::obtain();
	$id = $db->escape($id);
	$sql = 'SELECT class, COUNT(*) FROM lobby_players WHERE playerid = '.$id.' GROUP BY class';
	$results = $db->fetch_array($sql);
	foreach ($results as $result) {
		$i = $result['class'];
		$counts[$i] = $result['COUNT(*)'];
		$class[$counts[$i]] = $result['class'];
	}
	if ($class[0] == max($counts))return $results[1]['class'];
	else {
		$count = max($counts);
		return $class[$count];
	}
}

function updateLocation($id,$ip) {
	if ($id) {
		$user = new User($id);
		if (!$user->hasLocation()) {
			$file = simplexml_load_file('http://api.ipinfodb.com/v2/ip_query.php?key=ca24e42293944a1bff78a2e8833baefb68fa34e2cb997c0becc7aaf4208a7706&ip='.$ip);
			$db = Database::Obtain();
			$data['latitude'] = $file->Latitude;
			$data['longitude'] = $file->Longitude;
			$where = 'id = '.$db->escape($id);
			$db->update('users',$data,$where);
		}
	}
}

function newUser($nickname,$steamid,$email,$country) {
	$db = Database::obtain();
	$data = array('steamid'  => $steamid,
				  'nickname' => $nickname,
				  'email'	 => $email,
				  'country'	 => $country);
	$sql = $db->insert('users',$data);
	$data2['id'] = $sql;
	$sql2 = $db->insert('ratings',$data2);
	return $sql;
}

class User
{
	public function __construct($id) 
	{
		$db = Database::obtain();
		$sql= 'SELECT * FROM users WHERE id = '.$db->escape($id);
		$userinfo = $db->query_first($sql);

		$this->id = $userinfo['id'];
		$this->nickname = $userinfo['nickname'];
		$this->steamid = $userinfo['steamid'];
		$this->country = $userinfo['country'];
		$this->email = $userinfo['email'];
		$this->banpoints = $userinfo['banpoints'];
		$this->rating = rating($this->id);
		$this->mainclass = mainclass($this->id);
		$this->avatar = APIGet($this->steamid,avatar);
		$this->etf2lid = str_replace('STEAM_', '', GetAuthID($this->steamid));
		$this->division = etf2ldiv($this->etf2lid);
		$this->latitude = $userinfo['latitude'];
		$this->longitude = $userinfo['longitude'];
		$this->status = $userinfo['status'];
	}


	public function display_profile($id, $full = true) 
	{
		if ($full)
			return '<h1>User Info</h1>
					<img class="small_avatar" src=' . $this->avatar . ' width="32" height="32"></img>
					<span class="user_name">' . $this->nickname . '</span>
					<span class="user_steamid">' . GetAuthID($this->steamid) . '</span>
					<dl>
						<dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/'.player_class($this->mainclass).'.png" height="14"><span style="float: left; margin-left: 3px;">'.displayClass($this->mainclass).'</span></dd>
						<dt>Skilllevel:</dt><dd>'.$this->division.'</dd>
						<dt>Banpoints:</dt><dd>'.$this->banpoints.'</dd>
						<dt>Rating:</dt><dd>' . $this->rating . '</dd>
					</dl>';
		else
			return '<div class="profile_panel">
						<h1>User Info</h1>
						<span class="user_name">' . $this->nickname . '</span><br />
						<span class="user_steamid">' . GetAuthID($this->steamid) . '</span>
						<dl>
							<dt>Mainclass:</dt><dd><img style="float: left;" class="class_icon" src="theme/images/class/'.player_class($this->mainclass).'.png" height="14"><span style="float: left; margin-left: 3px;">'.displayClass($this->mainclass).'</span></dd>
							<dt>Skilllevel:</dt><dd>' . $this->division . '</dd>
							<dt>Rating:</dt><dd>' . $this->rating . '</dd>
						</dl>
					</div>';
	}


	public static function get_id($steamid) 
	{
		$db = Database::obtain();
		$query = $db->query("SELECT id FROM users WHERE steamid = ".$db->escape($steamid)." LIMIT 1");
		$result = $db->fetch($query);
		return $result['id'];
	}

	public static function get_steamid($id) 
	{
		$db = Database::obtain();
		$query = $db->query("SELECT steamid FROM users WHERE id = ".$db->escape($id)." LIMIT 1");
		$result = $db->fetch($query);
		return $result['steamid'];
	}

	public function hasLocation() {
		if ($this->latitude && $this->longitude) return true;
		else return false;	
	}

	public function updateDetails($details) {
		$db = Database::obtain();
		$details['nickname'] = htmlentities($details['nickname'], ENT_QUOTES);
		$where = 'id = '.$db->escape($this->id);
		$db->update('users',$details,$where);

	}

	public function countrySelect() {
		$html = '';
		$countries = array(
			'AT' => 'Austria',
			'BY' => 'Belarus',
  			'BE' => 'Belgium',
  			'BA' => 'Bosnia Herzegovina',
			'BG' => 'Bulgaria',
			'HR' => 'Croatia',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'EE' => 'Estonia',
			'FI' => 'Finland',
			'FR' => 'France',
			'DE' => 'Germany',
			'GR' => 'Greece',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IE' => 'Ireland',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'LV' => 'Latvia',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MK' => 'Macedonia',
			'MT' => 'Malta',
			'NL' => 'Netherlands',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'RO' => 'Romania',
			'RU' => 'Russia',
			'RS' => 'Serbia',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'ES' => 'Spain',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'TR' => 'Turkey',
			'UK' => 'United Kingdom',
			'UA' => 'Ukraine',
			'EU' => 'European',
			'US/CA' => 'US/CA',
			'INT' => 'International');
		foreach ($countries as $country) {
			if ($country == $this->country) $html .= '<option value="'.$country.'" selected="selected">'.$country.'</option>';
			else $html .= '<option value="'.$country.'">'.$country.'</option>';
		}
		return $html;
	}
}
?>