<?php

function rating($id)
{
	$query =  'SELECT * FROM ratings WHERE id = '.mysql_real_escape_string($id);
	$result = mysql_query($query);
	$ratinginfo = mysql_fetch_assoc($result);
	
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
	$sql = 'SELECT rated FROM lobby_players WHERE id = '.mysql_real_escape_string($source);
	$query = mysql_query($sql);
	$rated = mysql_fetch_assoc($query);
	$rated = $rated['rated'];
	$rates = explode(',', $rated);
	foreach ($rates as $rate) {
		if ($rate != $target) $allow = true;
		else $allow = false;
	}
	if ($allow) {
			if ($rated == "") $rated .= $target; 
            else $rated .= ','.$target;
            $rated = mysql_real_escape_string($rated);
			$sql = 'UPDATE lobby_players SET rated = \''.$rated.'\' WHERE id = '.$source;
			mysql_query($sql); 
			if ($value == 1) {
				$sql = 'UPDATE ratings SET plus = plus + 1 WHERE id = '.$target;		
			} else {
				$sql = 'UPDATE ratings SET minus = minus + 1 WHERE id = '.$target;
			}
			mysql_query($sql);
	} else echo 'You already rated this player';
}


?>