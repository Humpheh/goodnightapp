<?php

include 'init.php';

?>

<?php require 'header.php'; ?>

<?php if(Logins::isLoggedIn()){
    include 'inc/session.php';
} else { ?>

    <div style="height:100%;width:100%;text-align:center;display:table">
        <div style="display:table-cell;vertical-align:middle;">
            <h1 style="font-size:100px;font-weight:bold;font-style:italic;">Hello</h1>
            <span style="font-size:30px;"><a href="login.php">Login</a> - <a href="register.php">Register</a></span>

            <a href="#" style="display:block;font-weight:normal;font-size:30px;width:100%;position:absolute;padding:15px 0;bottom:0px;">
                Next<br/>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
        </div>
    </div>

    You are not logged in. <a href="login.php">Login</a> - <a href="register.php">Register</a>
<?php } ?>

<?php require 'footer.php'; ?>
