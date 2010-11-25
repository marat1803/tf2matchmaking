<?php
echo basename($_GET[openid_claimed_id]);
?>
<a href='https://steamcommunity.com/openid/login?openid.ns=http://specs.openid.net/auth/2.0&openid.mode=checkid_setup&openid.return_to=http://localhost/test.php&openid.realm=http://localhost/test.php&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.identity=http://specs.openid.net/auth/2.0/identifier_select'><img id='openid' src='http://steamcommunity.com/public/images/signinthroughsteam/sits_small.png' /></a>