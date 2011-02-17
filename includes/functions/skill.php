<?php

function division($id) { 
	$user = new User($id);
	$division = str_replace('Division', '', $user->division);
	if ($user->division == 'Division Premier') return 0;
	elseif ($division) return $division;
	else return 0;
}

function kdr($kills,$assists,$deaths) {
	if (((($kills+$assists)/$deaths)/0.75) >= 1) return 1;
	else return ((($kills+$assists)/$deaths)/0.75);
}

function gWonRatio($won,$lost) {
	if ((($won/($won+$lost))/0.75) >= 1) return 1;
	else return (($won/($won+$lost))/0.75);
}

function skill($id) {
	if ($division != 0) $division = 100*(7-division($id))/7;
	else $division = 1;
	$skill = $division;//*($rating)*($adminMark)*(kdr($kills,$assists,$deaths))*gWonRatio($won,$lost);
	return intval($skill);
}

?>