<?php

require_once 'includes/header.php';


if(isset($_POST['team']) && ($_POST['id']) && ($_POST['uid'])) {
$lpid = getLPid(($_POST['uid']),($_POST['id']));
joinTeam($lpid,$_POST['team']);
header('Location: lobby.php?id='.$_POST['id'].'&uid='.$_POST['uid']);
}
else {
$id = $_REQUEST['id'];
$uid = $_REQUEST['uid'];
displaylobby($id);

echo '<form name="team" action="lobby.php" method="post">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="uid" value="'.$uid.'">
<input type="submit" name="team" value="1" />
<input type="submit" name="team" value="2" /></form>';
}
?>