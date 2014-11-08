<?php

include 'init.php';

?>

<?php require 'header.php'; ?>

<?php if(Logins::isLoggedIn()){
    include 'inc/session.php';
} else { 

    // form has been submitted
if (!empty($_POST['password']) && !empty($_POST['username'])){
    $userpass = $_POST['password'];
    $username = $_POST['username'];

    // try to login
    if (Logins::login($username, $userpass)){
        header("Location: index.php");
        exit();
    }
} ?>


<div style="height:100%;width:100%;text-align:center;display:table">
    <div style="display:table-cell;vertical-align:middle;">
        <section id="homeSection">
            <div class="container">
                <h1 style="font-size:100px;font-weight:bold;font-style:italic;color:white;">Great Night!</h1>
                <span style="font-size:30px;"><a href="login.php">Login</a> - <a href="register.php">Register</a></span>

                <a href="#" style="display:block;font-weight:normal;font-size:30px;width:100%;position:absolute;padding:15px 0;bottom:0px;">
                    Next<br/>
                    <span class="glyphicon glyphicon-chevron-down"></span>
                </a>
            </div>
        </section>
        <section>
            <div class="container">
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
        </section>
    </div>
</div>
<script type="text/javascript" src="js/onepagescroll/jquery.onepage-scroll.js"></script>

You are not logged in. <a href="login.php">Login</a> - <a href="register.php">Register</a>
<?php } ?>

<?php require 'footer.php'; ?>


