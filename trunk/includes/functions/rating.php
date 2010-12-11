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

?>