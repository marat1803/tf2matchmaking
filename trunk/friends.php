<?php

require_once 'includes/header.php';

$id = 1;
$curumeu=queryfr($id);
foreach($curumeu as $cur) {
print $cur;
}


?>