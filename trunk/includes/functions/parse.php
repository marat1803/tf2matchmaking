<?php 

function parse($logf) {
	$logs = explode('\n',$logf);
	$loginfo = array(
		"connection"     => array(),
		"enterGame"      => array(),
		"disconnection"  => array(),
		"joinTeam"       => array(),
		"changeClass"    => array(),
		"roundStartTime" => 0,
		"score"          => array()
	);
	foreach ($logs as $log) {
		$value = parseLine($log, $loginfo);
		if($value == 0) {
			continue;
		}
		if($value == 1) {
			// it's the beginning of the round
			// clear out loginfo to start a new round
			$loginfo = array(
				"connection"     => array(),
				"enterGame"      => array(),
				"disconnection"  => array(),
				"joinTeam"       => array(),
				"changeClass"    => array(),
				"roundStartTime" => 0,
				"score"          => array()
			);
		}
		if($value == 2) {
			// it's the end of the round
			// process the round info and break out of the foreach

			//stuff
			return 2;
			break;
		}
	}
}

/**
 * parses a line of the log file, and puts the data into $loginfo.
 * Returns 0 on a regular line, 1 when it's starting a new round, 2 when ending a round.
 */
function parseLine($logline, &$loginfo) {

// L 03/10/2011 - 20:51:10: Log file started (file "logs/L0310015.log") (game "/home/u405/255.255.255.255-20200/tf2/orangebox/tf") (version "4489")


// connection
//L 03/14/2011 - 22:58:50: "Annuit Cœptis<21><STEAM_0:0:11767165><>" connected, address "255.255.255.255:27005"
preg_match(
	'#<STEAM_0:(?P<uid>[01]:\d+)><>" connected, address "(?P<server>\d+\.\d+\.\d+\.\d+:\d+)"#',
	$logline, $connection
);
if($connection) {
	$loginfo['connection'][] = $connection;
	return 0;
}

// enter game
//"Name<uid><wonid><>" entered the game
//L 03/14/2011 - 22:59:04: "Annuit Cœptis<21><STEAM_0:0:11767165><>" entered the game
preg_match(
	'#<STEAM_0:(?P<uid>[01]:\d+)><>" entered the game#',
	$logline, $enterGame
);

if($enterGame) {	
	$loginfo['enterGame'][] = $enterGame;
	return 0;
}

// disconnection
//"Name<uid><wonid><team>" disconnected
//L 03/14/2011 - 23:37:10: "voL.Fzero<29><STEAM_0:0:1463936><Red>" disconnected (reason "Disconnect by user.")
preg_match(
	'#<STEAM_0:(?P<uid>[01]:\d+)><(?:Red|Blue)>" disconnected (reason "(?P<reason>.*?)")#',
	$logline, $disconnect
);

if($disconnect) {
	$loginfo["disconnect"][] = $disconnect;
	return 0;
}


// team selection
//"Name<uid><wonid><team>" joined team "team"
//L 03/14/2011 - 22:59:08: "Annuit Cœptis<21><STEAM_0:0:11767165><Unassigned>" joined team "Blue"
preg_match(
	'#<STEAM_0:(?P<uid>[01]:\d+)><.*?>" joined team "(?:Blue|Red)"#',
	$logline, $joinTeam
);

if($joinTeam) {
	$loginfo["joinTeam"][] = $joinTeam;
	return 0;
}

// role selection
//"Name<uid><wonid><team>" changed role to "role"
//L 03/14/2011 - 23:07:38: "St.Patrick<22><STEAM_0:1:9117438><Blue>" changed role to "soldier"
preg_match(
	'#<STEAM_0:(?P<uid>[01]:\d+))><(?:Blue|Red)>" changed role to "(?P<role>.*?)"#',
	$logline, $changeClass
);

if($changeClass) {
	$loginfo["changeClass"][] = $changeClass;
	return 0;
}

// start game
// L 03/14/2011 - 23:15:21: World triggered "Round_Start"
preg_match(
	'#(?P<date>\d{2}\/\d{2}\/\d{4})\s+-\s+(?P<time>\d{2}:\d{2}:\d{2}): World triggered "Round_Start"#',
	$logline, $roundStart
);

if($roundStart) {
	$loginfo["roundStartTime"] = $roundStart;
	return 1;
}

// win round:
// L 03/07/2011 - 19:48:57: Team "Blue" current score "5" with "6" players
preg_match(
	'#Team "(?P<team>Blue|Red)" current score"(?P<score>\d+)" with "(?P<playerCount>\d+)" players#',
	$logline, $score
);

if($score) {
	$loginfo["score"][$score["team"]] = array(
		"score" => $score["score"],
		"players" => $score["players"]
	);
	if(isset($loginfo["score"]["Blue"], $loginfo["score"]["Red"])) {
		return 2;
	}
}


//L 03/10/2011 - 20:53:42: "Tommy Testosterone<5><STEAM_0:1:22116618><Red>" killed "Belial >Air*<3><STEAM_0:0:19129863><Blue>" with "pistol_scout" (attacker_position "1435 -2618 320") (victim_p
'#<STEAM_0:(?P<attackerUid>[01]:\d+)><(?:Blue|Red)> killed ".*?<STEAM_0:(?P<killedUid>[01]:\d+)><(?:Blue|Red)>" with "(?P<weapon>.*?)"#'




?>