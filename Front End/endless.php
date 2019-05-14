<?php 
session_start();
?>
<html>
<head>
<script src ="jquery.min.js"></script>
</head>
<body>
<div id="players"><div id="One" style="left: 0px;"><?php echo $_SESSION['username'] . ": " . $_SESSION['score'] . ": " . $_SESSION['curscore'];?> </div></div><div class="arrow-right" onclick="reloadFrame()";></div>
<script>
var player = [0,0,0,0];
function add(plr, points, answer){
	var ansin = prompt("What is your answer? " + answer);
	if(ansin.includes(answer)){
		player[plr] += points;
		alert("Player" + (plr + 1) + " is correct and earned " + points + " points!");
		switch(plr){
			case 0:
				alert("Player1: <br>" + player[plr]);
				document.getElementById("One").innerHTML = "<b>Player 1:</b> <br><br>" + player[plr];
				break;
			case 1:
				document.getElementById("Two").innerHTML = "<b>Player 2:</b> <br><br>" + player[plr];
				break;
			case 2:
				document.getElementById("Three").innerHTML = "<b>Player 3</b>: <br><br>" + player[plr];
				break;
			case 3:
				document.getElementById("Four").innerHTML = "<b>Player4</b> : <br><br>" + player[plr];
				break;
		}
	
	}
	else{
		alert("nah dog, that's wrong");
	}	
}
function reloadFrame(){
	location.reload();
	//document.getElementById('Game').contentWindow.location.reload();
}
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
		if(data == "authenticated"){
			window.location = "welcome.php";		
		}
		if(data == "notAuthenticated"){
			alert("Failed to login with those credentials. Please check your username and password or click on 'Register' in order to register.");		
		}
    	 }
	 $('#RecResults').append(data+"<p>");
	 //$('#myForm')[0].reset();
    });
} 

function hideBox(e){
	e.style.visibility="hidden";
	//alert("el");
}
</script>
<iframe id="Game" style="width: 100%; height: calc(100% + 32px); top: -32px;"src="endlessBoard.php">

</iframe>
</body>

<style>
#players{
	width: 100%;
	height: 64px;
	position: absolute;
	left: 0px;
	top: -96px;
	background: green;
}
#One, #Two, #Three, #Four{
	border: 1px solid white;
	position: absolute;
	width: 100%;
	height: 64px;
	background: green;
	text-align: center;
}

#box{
	border: 4px solid white;
	display: flex;
	justify-content: center;
	align-items: center;
	color: white;
	font-size: 1.5vh;
	padding-left: .5%;	
}
#box:hover{
	color: yellow;
	border: 4px solid yellow;
}
#box:selected{
}

.arrow-right {
  position: fixed;
  width: 0; 
  height: 0; 
  border-top: 60px solid transparent;
  border-bottom: 60px solid transparent;
  
  border-left: 60px solid green;
  top: calc(50% - 30px);
  left: calc(100% - 72px);
}

body{
background: white;
position: absolute;
width: 100%;
height: calc(100% - 96px);
top: 96px;
left: -10px;

}
html{
height: 100%;
width: 100%;
position: absolute;
left: 0px;
top: 0px;
}
</style>
</html>
