<?php

// TF2 Matchmaking Config

// Database

$host = "localhost";
$user = "root";
$pass = "";
$dbase = "tf2mm";

require_once 'includes/classes/class.mysql.php';

$db = Database::obtain($host, $user, $pass, $dbase);
$db->connect();

// Debugging

$debugging = "1";

?>