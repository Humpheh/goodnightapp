<?php
header("Content-Type: application/json");
include '../init.php';

$userLogin = json_decode($_GET['jsondata']);
// form has been submitted
if (!empty($userLogin['username']) && !empty($userLogin['password'])){
	$userpass = $userLogin['username'];
	$username = $userLogin['password'];

    	// try to login
	if (Logins::login($username, $userpass)){
		echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
	}else{
		echo $_GET['callback'] . '(' . "{'response' : 'FAILURE}" . ')';
	}
}

?>