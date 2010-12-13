<?php

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



function etf2ldiv($etf2lsteamid) {

$xmlUrl = 'http://etf2l.org/feed/player/?steamid='.$etf2lsteamid; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);

$json = json_encode($arrXml);
$api = json_decode($json);
//print_r($api);
//print_r($arrXml);

if(isset($api->player)) {
    foreach ($api->player->teams->team as $team) {
        if (isset($team->comp) && $team->{'@attributes'}->type == '6on6') {
            foreach (array_reverse($team->comp) as $comp) {
                if(isset($comp->{'@attributes'}->division)) {
                    $division = $comp->{'@attributes'}->division;
                    if ($division == 'Premier Division') return 'Premier';
                    else {
                        $divnumber = preg_replace('#Division#', '', $division);
                        return substr($divnumber,  0, -1);
                    }
                }
            }
        }
    }
}
/*
if(array_key_exists('player', $arrXml)) {
    foreach($arrXml['player']['teams']['team'] as $team) {
        if($team['@attributes']['type'] != '6on6') {
            continue;
        }
        if(isset($team['comp'])) {
            foreach($team['comp'] as $comp) {
                if ($comp != "") {
                    return preg_replace('#^Division#', '', $comp['@attributes']['division']).'<br/>';
                }
           }
        }
        //echo $team['@attributes']['name'].'<br/>'; 
    }
    }*/
}

?>