<?php

function rating($id)
{
	$query =  'SELECT * FROM ratings WHERE id = '.$id;
	$result = mysql_query($query);
	$ratinginfo = mysql_fetch_assoc($result);
	
	if (($ratinginfo['plus'] + $ratinginfo['minus']) == 0)
	$ratingscore['id'] = "0.45";
	else $ratingscore['id'] = $ratinginfo['plus'] / ($ratinginfo['plus'] + $ratinginfo['minus']);
	
	if ($ratingscore['id'] >= 0.8) { return "+++"; }
	elseif ($ratingscore['id'] >= 0.7) { return "++"; }
	elseif ($ratingscore['id'] >= 0.55) { return "+"; }
	elseif ($ratingscore['id'] == 0.45) { return "+/-"; }
	elseif ($ratingscore['id'] >= 0.3) { return "-"; }
	elseif ($ratingscore['id'] >= 0.2) { return "--"; }
	elseif ($ratingscore['id'] < 0.2) { return "---"; }
}

?>