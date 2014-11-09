<?php

include '../init.php';

$stats = Tools::calcStats(Logins::getCurrentSession());
$statsA = Tools::calcStatsUser(Logins::getCurrentUserID());

$json = "{";
$json .= '"units" : ' . $stats['units'] . ',';
$json .= '"calories" : ' . $stats['calories'] . ',';
$json .= '"totunits" : ' . $statsA['units'] . ',';
$json .= '"totcalories" : ' . $statsA['calories'];
$json .= '}';

echo $json;
