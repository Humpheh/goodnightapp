<?php
header("Content-Type: application/json");
include 'init.php';

// is the user loggedin
if (Logins::isLoggedIn()){
	echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
}

mysqli_close($con);

?>