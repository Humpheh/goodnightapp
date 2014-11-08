<?php

include 'init.php';

// is the user loggedin
if (Logins::isLoggedIn()){
    header("Location: index.php");
    exit();
}

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

?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <input type="text"      name="username" placeholder="username" />
        <input type="password"  name="password" placeholder="password" />
        <input type="submit"    name="login" />
    </form>
</body>
</html>
