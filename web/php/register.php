<?php
header("Content-Type: application/json");
include '../init.php';

$register = json_decode($_GET['jsondata']);
// form has been submitted
$row = array("password" => $register['password'],
	"username" => $register['username'],
	"weight"   => $register['weight'],
	"gender"   => $register['gender']);

	  // try to login
	  if (Logins::register($row)){
	      echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
	}else{
		echo $_GET['callback'] . '(' . "{'response' : 'FAILURE}" . ')';
	}
}

?>