<?php

function rating($id)
{
	$db = Database::obtain();
	$query =  'SELECT * FROM ratings WHERE id = '.$db->escape($id);
	$result = $db->query($query);
	$ratinginfo = $db->fetch($result);

	if (($ratinginfo['plus'] + $ratinginfo['minus']) == 0)
	$ratingscore = "0.45";
	else $ratingscore = $ratinginfo['plus'] / ($ratinginfo['plus'] + $ratinginfo['minus']);
	
	if ($ratingscore >= 0.8) return "+++";
	elseif ($ratingscore >= 0.7) return "++";
	elseif ($ratingscore >= 0.55) return "+";
	elseif ($ratingscore == 0.45) return "+/-";
	elseif ($ratingscore >= 0.3) return "-";
	elseif ($ratingscore >= 0.2) return "--";
	elseif ($ratingscore < 0.2) return "---";
}

function rate($source,$target,$value) {
	global $user;
	$db = Database::obtain();
	$sql = 'SELECT rated FROM lobby_players WHERE id = '.$db->escape($source);
	$query = $db->query($sql);
	$rated = $db->fetch($query);
	$rated = $rated['rated'];
	$rates = explode(',', $rated);
	$allow = true;
	foreach ($rates as $rate) {
		if ($rate == $target) $allow = false;
		if ($user->id == $target) $allow = false;
	}
	if ($allow) {
			if ($rated == "") $rated .= $target; 
            else $rated .= ','.$target;
            $rated = $db->escape($rated);
			$data['rated'] = $rated;
			$where = 'id = '.$db->escape($source);
			$sql = $db->update('lobby_players',$data,$where);
			$db->query($sql); 
			if ($value == 1) {
				$data['plus'] = 'INCREMENT(1)';
				$where = 'id = '.$db->escape($target);
				$sql = $db->update('ratings',$data,$where);
			} else {
				$data['minus'] = 'INCREMENT(1)';
				$where = 'id = '.$db->escape($target);
				$sql = $db->update('ratings',$data,$where);
			}
			$db->query($sql);
	} else echo 'You already rated this player';
}


?>