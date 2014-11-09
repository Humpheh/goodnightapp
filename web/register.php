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
<script> $(document).ready(function(){

    $(".main").onepage_scroll({
       sectionContainer: "section", // sectionContainer accepts any kind of selector in case you don't want to use section
       easing: "ease", // Easing options accepts the CSS3 easing animation such "ease", "linear", "ease-in", "ease-out", "ease-in-out", or even cubic bezier value such as "cubic-bezier(0.175, 0.885, 0.420, 1.310)"
       animationTime: 900, // AnimationTime let you define how long each section takes to animate
       pagination: true, // You can either show or hide the pagination. Toggle true for show, false for hide.
       updateURL: false // Toggle this true if you want the URL to be updated automatically when the user scroll to each page.
    });
    
});

function init() {
    
    // start up after 2sec no matter what
    window.setTimeout(function(){
        start();
    }, 2000);
}

// fade in experience
function start() {
    
    $('body').removeClass("loading").addClass('loaded');
    
}

$(window).load(function() {
    
    // fade in page
    init();
    
});
</script>
<div id="register">
<div style="padding-top:10%;padding-right:20%;padding-left:20%;" class="container">
<center><h1 style="padding-bottom:30px;font-weight: bold;font-style: italic;font-size:50px;color:rgb(195, 193, 193);">Register</h1></center>

<form method="POST" role="form">
    <div class="form-group">
        <input type="text" name="username" placeholder="username" class="form-control"/>
    </div>
    <div class="form-group">
        <input type="password" name="password" placeholder="password" class="form-control"/>
    </div>
    <div class="form-group">
        <input type="text" name="weight" placeholder="weight" class="form-control"/>
    </div>
    <div class="form-group">
        <select name="gender" class="form-control">
            <option value="none">-</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>
    <input type="submit" name="register" class="btn btn-primary btn-lg btn-block"/>
</form>
</div>
</div>
<?php require 'footer.php'; ?>
