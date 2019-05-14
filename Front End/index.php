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
	 $('#SendResults').append(data+"<p>");
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
			window.location = "welcome.php";		
		}
		if(data.includes("n")){
			alert("Failed to login with those credentials. Please check your username and password or click on 'Register' in order to register.");		
		}
		else{
			alert("Else: " + data + "|||");
		}
    	 }
	 $('#RecResults').append(data+"<p>");
	 //$('#myForm')[0].reset();
    });
} 
</script>
</head
<body>
<div class="form">

<form method="post">
    <div class="textin">
	Login:

    	<input type="text" name="username" id="username" class="username" placeholder="Username" required/>
    	<input type="password" name="password" id="password" class="password" placeholder="Password" required/>
    </div>
	<p></p>
    <div class="buttons">
	<!--sendQueue(<queue name>)-->
    	<input type="button" class="button" name="send" value="Submit" id="send" onClick="sendQueue('auth');"/>
	<a href="register.php" style="color: gray; text-align:right;" class="buttons"> Register </a>
    	<!--<input type="button" class="button" name="recieve" value="Register" id="recieve" onClick="recQueue('hello');"/>-->
    </div>
</form>
</div>
<div id="SendResults">
	Send:
	<p>
</div>
<div id="RecResults">
	Recieve:
	<p>
</div>

<style>
.form{
	position: absolute;
	//height: 30%;
	width: 40%;
	left:26%;
	top: 34%;
	background: white;
	padding: 2%;
	margin: 2%;
	margin-bottom: 0;
	padding-bottom: 0;
	border-radius: 16px;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.textin{
	position: relative;
	left: 16%
	width: 10%;
	height: 50%;
	font-size: 1.5vh

}
.username{
	width: 100%;
	height: 50%;
	border: none;
	background: rgba(0, 0, 0, 0.2);
	padding: 8px;
	margin-bottom: .5vh;
	border-radius: 8px;
	font-size: 1.5vh;
}
.password{
	width: 100%;
	height: 50%;
	border: none;
	background: rgba(0, 0, 0, 0.2);
	padding: 8px;
	border-radius: 8px;
	font-size: 1.5vh;
}
.buttons{
	top: 50%;
	position: relative;
	width: 100%;
}
.button{
	margin-top: .5vh;
	height: 5vh;
	width: 80%;
	border: none;
	background: #76b852; /* fallback for old browsers */
  	background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  	background: -moz-linear-gradient(right, #76b852, #8DC26F);
  	background: -o-linear-gradient(right, #76b852, #8DC26F);
  	background: linear-gradient(to left, #76b852, #8DC26F);
	border-radius: 8px;
	box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.7), 0 1px 1px 0 rgba(0, 0, 0, 0.7);
	font-size: 1.5vh
}
body{
	background: #76b852; /* fallback for old browsers */
  	background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  	background: -moz-linear-gradient(right, #76b852, #8DC26F);
  	background: -o-linear-gradient(right, #76b852, #8DC26F);
  	background: linear-gradient(to left, #76b852, #8DC26F);
}
</style>
</body>
</html>
