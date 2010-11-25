<?php
require 'includes/header.php';


if(isset($_SESSION['steamid']))
{	echo '<img>' . $user->nickname . '<br />'
. 'STEAM:' . GetAuthID($user->steamid) . '<br />'
. 'main class: ' . '' . '<br />'
. 'skill level: ' . '' . '<br />'
. 'banpoints:' . $user->banpoints . '<br />'
. 'rating: ' . $user->rating . '<br />'
; 
echo "<br /> <br />";
echo 'LOBBY LAWL:<br />' .$lobby->name .'<br />'
. 'Region:' .$lobby->region .'<br />'
. 'Players:' .$lobby->players .'<br />'
. 'Rules:' .$lobby->rules .'<br />'
. 'Status:' .$lobby->status .'<br />'
;
}
else header('Location: login.php');

?>