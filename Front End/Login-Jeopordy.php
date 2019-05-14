<?php 
session_start();
?>
<html>
<head>
<script src ="jquery.min.js"></script>
<script>
function sendQueue(q) {
    var name = $('#username').val();
    var password = $('#password').val();
    //var phone = $("#phone").val();
    //var gender = $("input[type=radio]:checked").val();
    //var message = "{ user : "+ name +" , " + name + " : ".$hash." }";
    $.post("send.php", { 'username': name, 'password': password, 'queue':q/*, phone: phone, gender: gender */ },
    function(data) {
	 //$('#SendResults').append(data+"<p>");
	 alert(data);
	 //$('#myForm')[0].reset();
    });
    if(q == "auth"){
    	recQueue("login");
    }
} 
function recQueue(q) {
    //var name = $('#username').val();
    //var name = $("#name").val();
    //var email = $("#email").val();
    //var phone = $("#phone").val();
    //var gender = $("input[type=radio]:checked").val();
    $.post("rec.php", {'username':name, 'queue':q/*name: name, email: email, phone: phone, gender: gender */},
    function(data) {
	 if(q == "login"){
		if(data.includes("a")){
			recQueue("scoreget");
			setTimeout(function(){
   				window.location = "welcome.php";
			}, 100);		
		}
		if(data.includes("n")){
			alert("Failed to login with those credentials. Please check your username and password or click on 'Register' in order to register.");		
		}
		else{
			//alert("Else: " + data + "|||");
		}
    	 }
	 //$('#RecResults').append(data+"<p>");
	 //$('#myForm')[0].reset();
    });
} 
</script>

<head>
	<meta charset="utf-8">
	
	<title>Jumbling Jeopordy </title>
	
	<style>
		
		body {
		
		font-family: "Didot";
		
		text-align: center;
		color: #404040;
		}
		
		img.bg {
			/* Set rules to fill background */
			min-height: 100%;
			min-width: 1024px;
			
			/* Set up proportionate scaling */
			width: 100%;
			height: auto;
			
			/* Set up positioning */
			position: fixed;
			top: 0;
			left: 0;
		}
		
		@media screen and (max-width: 1024px){
			img.bg {
				left: 50%;
				margin-left: -512px; }
		}
		
		#page-wrap {
		position: relative;
		width: 350px;
		margin: 60px auto;
		padding: 44px;
		background: white;
		-moz-box-shadow: 0 0 20px black;
		-webkit-box-shadow: 0 0 20px black;
		box-shadow: 0 0 20px black; }	
		
		#list{
			list-style-type: none;
			text-align:center;
		}
		#login-header{
			font-size: 1.5rem;
			font-weight: 600;
			padding:0;
			margin-top:10px;
			margin-bottom:10px;
			text-align: center;
		}
		#logo{
			max-width: 524px;
			height: 48px;
			text-align: center;
		}
		#username, #password{
			border-top-width: 0;
			border-left-width: 0;
			border-right-width: 0;
			padding-left: 0;
			
			border-color: rgba(0,0,0,.6);
			border-style: solid;
			height: 36px;
			outline: none;
			border-radius: 0;
			-webkit-border-radius: 0;
			border-top: 1px;
			border-left: 1px;
			border-right: 1px;
			border-width: 1px;
			width: 100%;
			background-image: none;
		}
		#form-group{
			font-size: .8125rem;
			line-height: 20px;
			font-weight: 400;
			line-height: 1.25rem;
			margin-bottom: 16px;
			margin-top: 16px;
			text-align: left;
			text-decoration:none;
		}
		#btn-container{
			text-align: right;
		}
		.btn{
			border: none;
			outline:none;
			
			text-align: center;
			border-color: #0067b8;
			background-color: #0067b8;
			height: 32px;
			min-width: 108px;
			-webkit-appearance: button;
			cursor: pointer;
			color: #fff;
			
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;

		}
		.btn:hover{
			background-color: #005da6;
			border-style: solid;
			border-width: 2px;
		}
		
		
		a {
		color: #0067b8;
		font-size: .8125rem;
		text-decoration: none;
		}
		
		a:hover {
		text-decoration: underline;
		color: #666;
		}
		.wrapper {
		position: relative;
		overflow: hidden;	
		}
		
		#slide {
		position: absolute;
		right: -200px;
		background: blue;
		transition: 2s;
		}
		
		.wrapper:active #slide {
		right: 0;
		}
		
		.btn:active #slide {
		transition: 2s;
		right: 0;
		}
	</style>
</head>

<body>

	<img src="Images/Jpbk.jpg" class="bg">
	
	
	<div id="page-wrap">
		<div class="wrapper">
		<img src="Images/Jo.png" id="logo">
		
		<form method="post">
		
			<div id="login-header" role="heading">Sign in</div>
			
			<div> <input id="username" class="username" type="text" name="username" placeholder="Username"></div>
			<div> <input id="password" class="password" type="password" name="password" placeholder="Password"></div>

			
			<div id="form-group"> No Account?<a href= "Registration-Jeopordy.php"> Create One!</a> </div>
			<div id="btn-container"> <!--
			<input class="button" id="send" name="send" type="button" value="Submit" onClick="sendQueue('auth');"/>-->
			<input type="button" class="btn" name="send" value="Submit" id="send" onClick="sendQueue('auth');"/></div>
			</div>
			
		</form>
	</div>
	
</body>

</html>
