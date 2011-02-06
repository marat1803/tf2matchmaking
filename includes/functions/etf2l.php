<?php


function etf2ldiv($etf2lsteamid) {
    $api = simplexml_load_file('http://etf2l.org/feed/player/?steamid='.$etf2lsteamid);
    $division = "No division";
    
    if(isset($api->player)) {
        foreach ($api->player->teams->team as $team) {
            if (isset($team->comp) && $team->attributes()->type == '6on6') {
                $current_compid = 0;
                foreach($team->comp as $c) {
                    if(isset($c->attributes()->division) && $c->attributes()->id > (int)$current_compid) {
                        $current_compid = $c->attributes()->id;
                        $div = $c->attributes()->division;
                        $divnumber = preg_replace('#Division#', '', $div);
                        $division = 'Division '. substr($divnumber,  0, -1);
                    }
                }
            }
        }
    }
    return $division;
}

function etf2l($steamid, $detail) {
    $steamid = str_replace('STEAM_', '', GetAuthID($steamid));
    $api = simplexml_load_file('http://etf2l.org/feed/player/?steamid='.$steamid);
    if ($detail == 'displayname') return $api->player->displayname;
    if ($detail == 'id') return $api->player->attributes()->id;
    if ($detail == 'url') return 'http://etf2l.org/forum/user/'.$api->player->attributes()->id.'/';

}

?>