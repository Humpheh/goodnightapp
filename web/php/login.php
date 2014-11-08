<?php
header("Content-Type: application/json");
include 'init.php';

// form has been submitted
if (!empty($_POST['password']) && !empty($_POST['username'])){
	$userpass = $_POST['password'];
	$username = $_POST['username'];

    // try to login
	if (Logins::login($username, $userpass)){
		header("Location: index.php");
		exit();
	}
}

mysqli_close($con);

?>