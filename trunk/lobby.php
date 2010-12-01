<?php

require_once 'includes/header.php';


if(isset($_POST['team']) && ($_POST['id'])) {
joinTeam($_POST['uid'],$_POST['id'],$_POST['team']);
}
else {
$id = $_POST['id'];
$uid = $_POST['uid'];
displaylobby($id);

echo '<form name="team" action="lobby.php" method="post">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="uid" value="'.$uid.'">
<input type="submit" name="team" value="1" />
<input type="submit" name="team" value="2" /></form>';
}
?>