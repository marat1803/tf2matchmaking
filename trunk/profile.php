<?php

require_once 'includes/header.php';

$id = $_GET['id'];
$steamid = displaySteamID($id);



echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>TF2 Matchmaking System</title>
    <link href="theme/style_profile.css" rel="stylesheet" type="text/css" />
    <link href="theme/uniform.default.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="background_image"></div>
    <div id="wrapper">
        <div id="header">
            <a href="index.php" id="logo">TF2 Matchmaking System</a>
        </div>
        <div id="content" class="big_panel">
            <ul class="nav_panel">
                <li><a href="index.php">Home</a></li>
                <li class="current"> &raquo; Profile (far from being finished, but at least some progress)</li>
            </ul>
            <div class="avatar_panel">
                <img class="avatar_big" src="'.APIGet($steamid,avatarfull).'">
                <a href="addfriend.php?id='.$id.'" class="friend_add button">+ Add</a>
            </div>
            '.$user->profileuser($id).'
            <dl class="stats_panel">
                <dt>Wins</dt><dd>7</dd>
                <dt>Losses</dt><dd>10</dd>
                <dt>Ratio</dt><dd>0.7</dd>
            </dl>
            <div class="friends_panel">
                <h1>Friends</h1>
                <ul>';
                echo getfriends($id).'
                </ul>
            </div>
    </div>
    <script src="theme/js/jquery.js" type="text/javascript"></script>
    <script src="theme/js/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="theme/js/main.js" type="text/javascript"></script>
</body>
</html>';


/*
$steamid = '0:1:16096891';

function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}



$xmlUrl = 'http://etf2l.org/feed/player/?steamid='.$steamid; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);

		
foreach($arrXml['player']['teams']['team'] as $team) {
	if($team['@attributes']['type'] != '6on6') {
		continue;
	}
	foreach($team['comp'] as $comp) {
			echo preg_replace('#^Division#', '', $comp['@attributes']['division']).'<br/>'; }
	}
//	echo $team['@attributes']['name'].'<br/>'; */


	
?>