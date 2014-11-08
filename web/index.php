<?php

include 'init.php';

?>

<html>
<head>
    <title>Home</title>
</head>
<body>
    <?php if(Logins::isLoggedIn()){ ?>
        You are logged in as <?php echo Logins::getCurrentUsername(); ?>. <a href="logout.php">Logout</a>
    <?php } else { ?>
        You are not logged in. <a href="login.php">Login</a> - <a href="register.php">Register</a>
    <?php } ?>
</body>
</html>

