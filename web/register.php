<?php

include 'init.php';

// is the user loggedin
if (Logins::isLoggedIn()){
    header("Location: index.php");
    exit();
}

// form has been submitted
if (   !empty($_POST['password']) && !empty($_POST['username'])
    && !empty($_POST['weight'])   && !empty($_POST['gender'])){
    $userpass   = $_POST['password'];
    $username   = $_POST['username'];
    $userweight = $_POST['weight'];
    $usergender = $_POST['gender'];

    $row = array("password" => $_POST['password'],
                 "username" => $_POST['username'],
                 "weight"   => $_POST['weight'],
                 "gender"   => $_POST['gender']);

    // try to login
    if (Logins::register($row)){
        header("Location: index.php");
        exit();
    }
}

?>

<?php require 'header.php'; ?>

<h1>Register</h1>

<form method="POST">
    <input type="text" name="username" placeholder="username" />
    <input type="password" name="password" placeholder="password" />

    <input type="text" name="weight" placeholder="weight" />
    <select name="gender">
        <option value="none">-</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    <input type="submit" name="register" />
</form>

<?php require 'footer.php'; ?>
