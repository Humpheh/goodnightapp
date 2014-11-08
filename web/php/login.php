<?php
header("Content-Type: application/json");
include 'init.php';

$userLogin = json_decode($_GET['jsondata']);
// form has been submitted
if (!empty($userLogin[0]) && !empty($userLogin[1])){
	$userpass = $userLogin[0];
	$username = $userLogin[1];

    	// try to login
	if (Logins::login($username, $userpass)){
		echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
	}else{
		echo $_GET['callback'] . '(' . "{'response' : 'FAILURE}" . ')';
	}
}

?>