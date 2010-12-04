<?php

require_once 'includes/header.php';

$id = $_GET['id'];


$user->profileuser($id); 
echo '<a href="addfriend.php?id='.$id.'">Add as friend</a>';

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