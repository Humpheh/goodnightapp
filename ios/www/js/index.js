 var loginInfo = new Array();
 var registerInfo = new Array();

//sets up the JSON query
function queryExternal(path, data, done, fail){
	$.getJSON(path, data, done).fail(function() {fail();});
}

var backendUrl = "http://10.36.8.70/goodnighthack/web/php";
var callback = "?callback=?";

 var app = {
    // Application Constructor
    initialize: function() {
    	this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
    	document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
    	app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
    	var parentElement = document.getElementById(id);
    	var listeningElement = parentElement.querySelector('.listening');
    	var receivedElement = parentElement.querySelector('.received');

    	listeningElement.setAttribute('style', 'display:none;');
    	receivedElement.setAttribute('style', 'display:block;');

    	console.log('Received Event: ' + id);
    }
  };


function checkLogin(){
	function done(res){//this code is called if the backend responds
		var response = res.response;
		if(response == "SUCCESS"){
			if(res.data == null){
				document.getElementById('loginResponse').innerHTML = "Incorrect login details.";
			}else{
				userInfo[1] = res.data[1];
				userInfo[2] = res.data[2];
				userInfo[3] = res.data[3];
				userInfo[4] = res.data[4];
				userInfo[5] = res.data[5];
				userInfo[6] = res.data[6];
				userInfo[7] = res.data[7];
				userInfo[8] = res.data[8];
				userInfo[9] = res.data[9];
				userInfo[10] = res.data[10];	
				userInfo[11] = res.data[11];						
				if(userInfo[2] == document.getElementById('loginPassword').value){
					document.getElementById('loginResponse').innerHTML = "";
					$.mobile.changePage("#page-home", { transition: "slidedown", changeHash: false })
					window.location.replace("#page-home");
					disableSliders();
				}else{
					document.getElementById('loginResponse').innerHTML = "Incorrect login details.";					
				}
			}
		}
		else{
			//changePage("#page-login");
			window.location.replace("#page-index");
		}
	}
	function fail(){
		//changePage("#page-login");
		window.location.replace("#page-index");
	}
	var loginArray = JSON.stringify(loginInfo);
	queryExternal(backendUrl + "/login.php" + callback, "jsondata=" + loginArray, done, fail);
}

function login(){
	loginInfo['username'] = document.getElementById('username').value;
	loginInfo['password'] = document.getElementById('password').value;
		
	if(loginInfo['username'] != "" || loginInfo['password'] != ""){
		function done(res){//this code is called if the backend responds
			var response = res.response;
			if(response == "SUCCESS"){
			}
			else{
			}
		}
		function fail(){
		}
		var loginArray = JSON.stringify(loginInfo);
		queryExternal(backendUrl + "/login.php" + callback, "jsondata=" + loginArray, done, fail);
	}else{
		document.getElementById('loginResponse').innerHTML = "Please fill in all details.";
	}
}

function register(){
	registerInfo['username'] = document.getElementById('username').value;
	registerInfo['password'] = document.getElementById('password').value;
	registerInfo['weight'] = document.getElementById('weight').value;
	registerInfo['gender'] = document.getElementById('gender').value;
		
	if(registerInfo['username'] != "" || registerInfo['password'] != "" || registerInfo['weight'] != "" || registerInfo['gender'] != ""){
		function done(res){//this code is called if the backend responds
			var response = res.response;
			if(response == "SUCCESS"){
			}
			else{
			}
		}
		function fail(){
		}
		var registerArray = JSON.stringify(registerInfo);
		queryExternal(backendUrl + "/register.php" + callback, "jsondata=" + registerArray, done, fail);
	}else{
		document.getElementById('loginResponse').innerHTML = "Please fill in all details.";
	}
}

function gotoLogin(){
	window.location.replace("login.html");
}

function gotoRegister(){
	window.location.replace("register.html");
}

app.initialize();