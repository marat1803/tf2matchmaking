<?php

require_once 'includes/header.php';



displayLobbyPlayers(1);

/*$lobbyID = "1";
$sql = "SELECT * FROM lobby_players WHERE `lobbyID` = ".$lobbyID;
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($res)) {
	$test_sql = mysql_query("SELECT * FROM users WHERE id = ".$row["playerid"]);
	while ($test_row = mysql_fetch_assoc($test_sql)) {
		echo '<p>'.$test_row["nickname"].'</p>';
	}
}*/

?>