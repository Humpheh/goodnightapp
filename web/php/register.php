<?php
header("Content-Type: application/json");
include '../init.php';

$register = json_decode($_GET['jsondata']);
// form has been submitted
$row = array("password" => $register[0],
	"username" => $register[1],
	"weight"   => $register[2],
	"gender"   => $register[3]);

// try to login
if (Logins::register($row)){
  	echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
}else{
	echo $_GET['callback'] . '(' . "{'response' : 'FAILURE}" . ')';
}

?>