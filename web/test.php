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


	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="js/jquery.onepage-scroll.js"></script>
  <link href='cs/onepage-scroll.css' rel='stylesheet' type='text/css'>
  <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">
  <style>
     html {
      height: 100%;
   }
    body {
      background: #E2E4E7;
      padding: 0;
      text-align: center;
      font-family: 'open sans';
      position: relative;
      margin: 0;
      height: 100%;
      -webkit-font-smoothing: antialiased;
    }
    
    .wrapper {
    	height: 100% !important;
    	height: 100%;
    	margin: 0 auto; 
    	overflow: hidden;
    }
  
	</style>
	<script>
	  $(document).ready(function(){
      $(".main").onepage_scroll({
        sectionContainer: "section",
        responsiveFallback: 600,
        loop: true
      });
		});
		
	</script>
</head>
<body>
  <div class="wrapper">
	  <div class="main">
	    
      <section class="page1">
        <div class="container">
                <h1 style="font-size:100px;font-weight:bold;font-style:italic;color:white;">Great Night!</h1>
                <span style="font-size:30px;"><a href="login.php">Login</a> - <a href="register.php">Register</a></span>

            </div>
      </section>
	    
	    <section class="page2">
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

<?php require 'footer.php'; ?>