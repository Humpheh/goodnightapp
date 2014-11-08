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


<?php require 'header.php'; ?>
<div class-"container">
<h1>Login</h1>

<form method="POST" role="form">
    <div class="form-group">
        <input type="text" name="username" placeholder="username" class="form-control"/>
    </div>
    <div class="form-group">
        <input type="password" name="password" placeholder="password" class="form-control"/>
    </div>
    <input type="submit" name="login" value="Login" class="btn btn-block btn-primary"/>
</form>
</div>
<?php require 'footer.php'; ?>
