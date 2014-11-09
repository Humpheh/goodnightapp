<?php

include '../init.php';

$hr = intval($_POST['hr']);
$min = intval($_POST['min']);

Logins::newSession($hr, $min);

header("Location: ../index.php");
