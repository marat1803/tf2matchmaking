<?php
/* Holds functions that can be reused for all pages */
function redirect($url,$time=5){
	echo '<meta http-equiv="refresh" content="'.$time.';url=http://'.$_SERVER['SERVER_NAME'].'/'.$url.'">';
}

function lastseen($id) {
	$sql = "UPDATE users SET lastseen = \"".mysql_real_escape_string(date('Y-m-d H:i:s'))."\" WHERE id = ".mysql_real_escape_string($id);
	mysql_query($sql);
}

function error($error) { 
	if ($_SESSION['id']) {
		$user_id = mysql_real_escape_string($_SESSION['id']);
	} else {
		$user_id = 0;
	}

	$page_url = mysql_real_escape_string($_SERVER['PHP_SELF']);

	if ($GLOBALS['debugging'] == "1") { 
		echo '<div class="error">'.$error.'</div>';
	} else {
		echo "DEBUGGING ISN'T ON, OR ISN'T SET PROPERLY";
	}
	$sql = "INSERT INTO error_log (error_text, user_id, page_url) VALUES ('".$error."',".$user_id.",'".$page_url."')";
	mysql_query($sql);
}

function esc_int ($input) {
	if (is_numeric($input)) {
		return mysql_real_escape_string($input);
	} else {
		error("Non-numeric characters entered");
		return 0;
	}
}


?>