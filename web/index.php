<?php

include 'init.php';

?>

<?php require 'header.php'; 

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
body{
  overflow:hidden;
}

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

<div class="top">

<div style="padding-top:13%;" class="container">
                <center><h1 style="padding-bottom:30px;font-size:100px;font-weight:bold;font-style:italic;color:black;">Good night.</h1>
                <span style="font-size:30px;"><a style="cursor:pointer;" id="loginBtn">Login</a> <i class="fa fa-beer"></i> <a href="register.php">Register</a></span>
              </center>
            </div>
</div>
<div class="middle">

<div style="padding-top:15%;padding-right:20%;padding-left:20%;"  class="container">
<center><b><h1 style = "padding-bottom:30px;font-weight: bold;font-style: italic;font-size:60px;">Login </h1></b></center>

                <form method="POST" role="form">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="username" class="form-control"/>
                    </div>
                    <div class="form-group" style="padding-bottom: 30px;">
                        <input type="password" name="password" placeholder="password" class="form-control"/>
                    </div>
                    <div style="padding-right:20%;padding-left:20%;"><input type="submit" name="login" value="Login" class="btn btn-block btn-primary"/></div>
                </form>
</div>
</div>

<?php }
require 'footer.php'; ?>