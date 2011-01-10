<?php


function etf2ldiv($etf2lsteamid) {

    $xmlUrl = 'http://etf2l.org/feed/player/?steamid='.$etf2lsteamid; // XML feed file/URL
    $xmlStr = file_get_contents($xmlUrl);
    $api = new SimpleXMLElement($xmlStr);


    if(isset($api->player)) {
        foreach ($api->player->teams->team as $team) {
            if (isset($team->comp) && $team->attributes()->type == '6on6') {
                $last_comp = $team->comp[sizeof($team->comp) - 1];
                    if(isset($last_comp->attributes()->division)) {
                        $division = $last_comp->attributes()->division;
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

?>