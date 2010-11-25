<?php
/* TF2 Matchmaking Config */

$host = "localhost";
$user = "root";
$pass = "";
$db = "tf2mm";

$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!");
mysql_select_db($db) or die ("Unable to select database!"); 
?>