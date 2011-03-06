<?php
/* Holds functions that can be reused for all pages */
function redirect($url,$time=5){
	echo '<meta http-equiv="refresh" content="'.$time.';url=http://'.$_SERVER['SERVER_NAME'].'/'.$url.'">';
}

function lastseen($id) {
	if ($id) {
		$db = Database::obtain();
		$data['lastseen'] = date('Y-m-d H:i:s');
		$where = 'id = '.$db->escape($id);
		$sql = $db->update('users',$data,$where);
	}
}

function error($error) { 
	if ($_SESSION['id']) {
		$user_id = $db->escape($_SESSION['id']);
	} else {
		$user_id = 0;
	}

	$page_url = $db->escape($_SERVER['PHP_SELF']);

	if ($GLOBALS['debugging'] == "1") { 
		echo '<div class="error">'.$error.'</div>';
	} else {
		echo "DEBUGGING ISN'T ON, OR ISN'T SET PROPERLY";
	}
	$db = Database::obtain();
	$data = array('error_text'	=> $error,
				  'user_id'		=> $user_id,
				  'page_url'	=> $page_url);
	$sql = $db->insert('error_log',$data);
}

function esc_int ($input) {
	if (is_numeric($input)) {
		return $db->escape($input);
	} else {
		//error("Non-numeric characters entered");
		return 0;
	}
}

function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
    $earth_radius = 6371;  
      
    $dLat = deg2rad($latitude2 - $latitude1);  
    $dLon = deg2rad($longitude2 - $longitude1);  
      
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
    $c = 2 * asin(sqrt($a));  
    $d = $earth_radius * $c;  
      
    return $d;  
}

function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return $difference.' '.$periods[$j].' ago ';
}


?>