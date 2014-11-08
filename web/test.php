<?php

include 'init.php';

require 'header.php';

if(Logins::isLoggedIn()){
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
	<meta charset="utf-8">

      <script>$("document").ready(function() {
 
                $('#loginBtn').click(function(){
 
                    $('html, body').animate({
                        scrollTop: $("#loginSection").offset().top
                    }, 2000);
 
                 });
 
});
</script>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="js/jquery.onepage-scroll.js"></script>
  <link href='cs/onepage-scroll.css' rel='stylesheet' type='text/css'>
  <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">

</head>
<body>
  <div class="wrapper">
	  <div class="main">
	    
        <div class="container">
                <h1 style="font-size:100px;font-weight:bold;font-style:italic;color:white;">Great Night!</h1>
                <span id="loginBtn" style="font-size:30px;"><a href="login.php">Login</a> - <a href="register.php">Register</a></span>

            </div>
	    
	      <div id="loginSection" class="container">
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
    </div>
  </div>

<?php }
require 'footer.php'; ?>