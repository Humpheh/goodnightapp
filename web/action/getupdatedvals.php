<?php

include '../init.php';

$stats = Tools::calcStats($sessionid);

$json = "{";
$json .= '"units" : ' . $stats['units'] . ',';
$json .= '"calories" : ' . $stats['calories'];
$json .= '}';

echo $json;
