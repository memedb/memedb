<?php
require('api.php');

$user = getUser();
$user->karma = 50;
$user->rank = 10;
$user->updateFields("karma", "rank");
?>