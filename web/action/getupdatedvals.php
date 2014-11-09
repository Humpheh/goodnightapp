<?php

include '../init.php';

$stats = Tools::calcStats(Logins::getCurrentSession());

$json = "{";
$json .= '"units" : ' . $stats['units'] . ',';
$json .= '"calories" : ' . $stats['calories'];
$json .= '}';

echo $json;
