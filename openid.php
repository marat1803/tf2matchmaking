<?php 
session_start (); 

require_once ("includes/class.openid.php"); 

// Get identity from user and redirect browser to OpenID Server 
if (isset ( $_POST ['openid_action'] ) && $_POST ['openid_action'] == "login") { 
    $openid = new SimpleOpenID ( ); 
    $openid->SetOpenIDServer( 'http://specs.openid.net/auth/2.0/server' ); 
    $openid->SetIdentity ( 'https://steamcommunity.com/openid/login' ); 
    //$openid->SetRequiredFields ( array ('email', 'fullname' ) ); 
    //$openid->SetOptionalFields ( array ('dob', 'gender', 'postcode', 'country', 'language', 'timezone' ) ); 
    if ($openid->GetOpenIDServer ()) { 
        $openid->SetApprovedURL ( 'http://' . $_SERVER ["HTTP_HOST"] . '/closed/openid.php' ); // Send Response from OpenID server to this script 
        $openid->Redirect (); // This will redirect user to OpenID Server 
    } else { 
        $error = $openid->GetError (); 
        echo "ERROR CODE: " . $error ['code'] . "<br>"; 
        echo "ERROR DESCRIPTION: " . $error ['description'] . "<br>"; 
    } 
    exit (); 
} else if (isset ( $_GET ['openid_mode'] ) && $_GET ['openid_mode'] == 'id_res') { 
    $openid = new SimpleOpenID ( ); 
    $openid->SetIdentity ( $_GET ['openid_identity'] ); 
    $openid_validation_result = $openid->ValidateWithServer (); 
    if ($openid_validation_result == true) { 
        $profileid = substr ( $_GET ['openid_claimed_id'], 36 ); 
        $SteamCommunityXML = "http://steamcommunity.com/profiles/" . $profileid . "?xml=1"; 
    } else if ($openid->IsError () == true) { 
        $error = $openid->GetError (); 
        echo "ERROR CODE: " . $error ['code'] . "<br/>"; 
        echo "ERROR DESCRIPTION: " . $error ['description'] . "<br/>"; 
        exit (); 
    } else { // Signature Verification Failed 
        echo "INVALID AUTHORIZATION"; 
        exit (); 
    } 
} else if (isset ( $_GET ['openid_mode'] ) && $_GET ['openid_mode'] == 'error') { 
    echo "ERROR FROM SERVER: " . $_GET ['openid_error']; 
    exit (); 
} else if (isset ( $_GET ['openid_mode'] ) && $_GET ['openid_mode'] == 'cancel') { // User Canceled your Request 
    echo "USER CANCELED REQUEST"; 
    exit (); 
} 

	echo '<form target="_self" method="post" onsubmit="this.login.disabled=true;">
	<input type="submit" value="Test me" name="login"/>
	<input type="hidden" value="login" name="openid_action"/>
	</form>';
?>