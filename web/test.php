<?php

include 'init.php';

?>

<?php require 'header.php'; ?>

<?php if(Logins::isLoggedIn()){
    if (Logins::getCurrentSession() == NULL)
        include 'inc/landing.php';
    else
        include 'inc/session.php';
} else { ?>

<script type="text/javascript">
$("document").ready(function() {      
        
        $('.top-title').click(function(){
                       
          $('html, body').animate({
            scrollTop: $(".middle").offset().top
          }, 2000);          
           
                       
         });
        
        
        
        $('.middle-title').click(function(){
                       
          $('html, body').animate({
            scrollTop: $(".bottom").offset().top
          }, 2000);          
           
                       
         });
        
        
          $('.bottom-title').click(function(){
                       
          $('html, body').animate({
            scrollTop: $(".top").offset().top
          }, 2000);          
           
                       
         });

});
</script>

<style>

.top, .middle, .bottom{
  padding:30px;
  }

.top{
  height:600px;
  background-color:#FFC;
  margin-bottom:30px;
  border:2px solid #FF9;
  }
  
  
.middle{
  height:600px;
  background-color:#FF9;
  border:2px solid #FF6;
  margin-bottom:30px;
  }
  
  
.bottom{
  height:600px;
  background-color:#FF6;
  border:2px solid #FF3;
  margin-bottom:30px;
  } 
  
.top-title, .middle-title, .bottom-title{
  cursor:pointer;
  margin-top:300px;
  text-align:center;
  text-decoration:underline;
  font-size:32px;
  font-weight:700;} 
</style>
</head>
<body>
<?php include '../includes/header.php';
        $link = '| <a href="http://papermashup.com/jquery-page-scrolling/">Back To Tutorial</a>';
?>
<h1>jQuery Offset Animation</h1>

<div class="main">


<div class="top">

<div class="container">
                <h1 style="font-size:100px;font-weight:bold;font-style:italic;color:white;">Great Night!</h1>
                <span style="font-size:30px;"><a id="loginBtn">Login</a> - <a href="register.php">Register</a></span>

            </div>

<div class="middle">

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
</div>


</div>

<?php include '../includes/footer.php';?>

</body>
</html>


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
	    
        
	    
	      <div id="loginSection" class="container">
                
            </div>
    </div>
  </div>

<?php }
require 'footer.php'; ?>