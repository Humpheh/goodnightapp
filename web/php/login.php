<?php
header("Content-Type: application/json");
include '../init.php';

$userLogin = json_decode($_GET['jsondata']);
// form has been submitted
$userpass = $userLogin[0];
$username = $userLogin[1];

	// try to login
if (Logins::login($username, $userpass)){
	echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
}else{
	echo $_GET['callback'] . '(' . "{'response' : 'FAILURE}" . ')';
}

?>