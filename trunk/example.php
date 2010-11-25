<?php
require('includes/class.openid.php');

function getXmlValueByTag($inXmlset,$needle,$skip){
        $resource    =    xml_parser_create();//Create an XML parser
        xml_parse_into_struct($resource, $inXmlset, $outArray);// Parse XML data into an array structure
        xml_parser_free($resource);//Free an XML parser
       $found = 0;
        for($i=0;$i<count($outArray);$i++){
            if($outArray[$i]['tag']==strtoupper($needle)){
				if($found == $skip) return array($outArray[$i]['value'], $found+1, $outArray[$i]['attributes']);
				else if($found < $skip) $found++;
            }
        }
        return false;
    }

function GetAuthID($i64friendID)
{
	$tmpfriendID = $i64friendID;
	$iServer = "1";
	if(bcmod($i64friendID, "2") == "0")
	{
		$iServer = "0";
	}
	$tmpfriendID = bcsub($tmpfriendID,$iServer);
	if(bccomp("76561197960265728",$tmpfriendID) == -1)
		$tmpfriendID = bcsub($tmpfriendID,"76561197960265728");
	$tmpfriendID = bcdiv($tmpfriendID, "2");
	return ("STEAM_0:" . $iServer . ":" . $tmpfriendID);
}

try {
    if(!isset($_GET['openid_mode'])) {
        if(isset($_POST['openid_identifier'])) {
            $openid = new LightOpenID;
            $openid->identity = $_POST['openid_identifier'];
            header('Location: ' . $openid->authUrl("http://specs.openid.net/Fauth/2.0/identifier_select"));
        }
?>
<form action="" method="post">
    OpenID: <input type="hidden" name="openid_identifier" value="http://steamcommunity.com/openid" /> <button>Submit</button><br/>
	<?php echo $_GET['error']; ?>
</form>
<?php
    } elseif($_GET['openid_mode'] == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        $openid = new LightOpenID;
		if(!$openid->validate()) header('Location: example.php');
		
		$steam = explode("/", $_GET['openid_identity']);
		//$steam[5] = "76561198003004418"; // Force steamID
		
		$content = implode(file("http://steamcommunity.com/profiles/".$steam[5]."?xml=1"));
		$avatar = getXmlValueByTag($content, "avatarIcon", 0);
		$name = getXmlValueByTag($content, "steamID", 0);
		
		
		$content = implode(file("http://steamcommunity.com/profiles/".$steam[5]."/games?xml=1"));
		$tf2 = false;
		while($r=getXmlValueByTag($content, "appID", $r[1]))
		{
			if($r[0] == "440") { $tf2 = true; break; }
		}
		echo "Hello <img src=\"".$avatar[0]."\"> ".$name[0]."<br/>";
		if($tf2) echo "You appear to have Team Fortress 2<br/>";
		else echo "You don't appear to have Team Fortress 2<br/>";
		$steamid = GetAuthID($steam[5]);
		echo "Your Steam ID is: ".$steamid."<br/>";
		
		$content = implode(file("http://etf2l.org/feed/player/?steamid=".$steamid));
		
		$etf2l['username'] = getXmlValueByTag($content, "username", 0);
		$etf2l['displayname'] = getXmlValueByTag($content, "displayname", 0);
		$etf2l['player'] = getXmlValueByTag($content, "player", 0);
		if($etf2l['player'][2]['ID'] != "")
		echo "Your ETF2L profile is: <a href=\"http://etf2l.org/forum/user/".$etf2l['player'][2]['ID'].">".$etf2l['displayname'][0]."</a>";
		else echo "You don't have an ETF2L profile.";
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}?>
<a href="http://steampowered.com">Powered by Steam</a>
</body>
</html>