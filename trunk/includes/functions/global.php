<?php
/* Holds functions that can be reused for all pages */
function redirect($url,$time=5){
	echo '<meta http-equiv="refresh" content="'.$time.';url=http://'.$_SERVER['SERVER_NAME'].'/'.$url.'">';
}

function lastseen($id) {
	$sql = "UPDATE users SET lastseen = \"".mysql_real_escape_string(date('Y-m-d H:i:s'))."\" WHERE id = ".mysql_real_escape_string($id);
	mysql_query($sql);
}

?>