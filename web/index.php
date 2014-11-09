<?php

require 'init.php';

require 'header.php';

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

<?php if(Logins::isLoggedIn()){
    if (Logins::getCurrentSession() == NULL)
        include 'inc/landing.php';
    else
        include 'inc/session.php';
} else { ?>
<meta name="viewport" content="width=device-width, height=device-height">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<script type="text/javascript">
$("document").ready(function() {

        $('#loginBtn').click(function(){

          $('html, body').animate({
            scrollTop: $(".middle").offset().top
          }, 500);


         });
});
</script>

<style>

.top, .middle, .bottom{
  padding:30px;
  }

.top{
  height:100%;
  }


.middle{
  height:100%;
  }


.top-title, .middle-title, .bottom-title{
  cursor:pointer;
  margin-top:300px;
  text-align:center;
  text-decoration:underline;
  font-size:32px;
  font-weight:700;}
</style>

<div id="home" class="top">

<div style="padding-top:13%;" class="container">
                <center><h1 style="font-size:80px;font-weight:bold;font-style:italic;color:rgb(195, 193, 193);">Good night.</h1>
                  <p style="padding-bottom:30px;color:rgb(195, 193, 193);">For good nights, and great mornings.</p>
                <span style="font-size:30px;"><a class="btn btn-default" style="cursor:pointer;" id="loginBtn">Get Started</a></span>
              </center>
            </div>
</div>
<div id="login"  class="middle">

<div style="padding-top:15%;padding-right:20%;padding-left:20%;"  class="container">
<center><b><h1 style = "padding-bottom:30px;font-weight: bold;font-style: italic;font-size:50px;color:rgb(195, 193, 193);">Login </h1></b></center>

                <form method="POST" role="form">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username" id="username" class="form-control"/>
                    </div>
                    <div class="form-group" style="padding-bottom: 30px;">
                        <input type="password" name="password" placeholder="Password" id="password" class="form-control"/>
                    </div>
                    <center><a class="btn ibtn btn-default" style="cursor:pointer;font-size:20px;" onclick="document.forms[0].submit()" id="loginBtn">Login</a><br>
                    <a class="btn btn-primary ibtn" style="font-size:17px;margin-top:10px;" href="register.php">Register</a></center>
                </form>
</div>
</div>

<?php }
require 'footer.php'; ?>
