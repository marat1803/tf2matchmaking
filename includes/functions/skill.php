<?php

function division($id) { 
}

function kdr($kills,$assists,$deaths) {
	if (((($kills+$assists)/$deaths)/0.75) >= 1) return 1;
	else return (($kills+$assists)/$deaths)/0.75);
}

function gWonRatio($won,$lost) {
	if ((($won/($won+$lost))/0.75) >= 1) return 1;
	else return ((($won/($won+$lost))/0.75);
}

function skill($id) {
$skill = (100*division($id)/7)*($rating)*($adminMark)*(kdr($kills,$assists,$deaths))*gWonRatio($won,$lost);
}

?>