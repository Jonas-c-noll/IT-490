<?php 
session_start();
?>
<html>
<head>
<script src ="jquery.min.js"></script>

</head>
<body>
<div class="topbar"><?php echo '<span id="un">'. $_SESSION['username'] .'</span>'. " Score: " . $_SESSION['score']; ?><div onClick="addFriend();"> add friend </div><div onClick="window.location = 'friendlist.php'"> friends list </div><div onClick="window.location = 'highscore.php'"> highscore </div></div>
<div class="box boxRight" onClick="window.location = 'board.php?d=' + String(ans);">
Jeapardy
</div>
<div class="box boxLeft" style="left:50%" onClick="button();">
Endless Mode
</div>
</body>
<script>
function addFriend(){
    var friend = prompt("What is your friend's name?");
    var username= $('#un').html();
    $.post("addfriend.php", { 'username' : username , 'friend': friend },
    function(data) {
	 alert(data);
    });
}
function fList(){
    $.post("friendlist.php", { },
    function(data) {
	 alert(data);
    });
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
function button(){
	var ans = prompt('Which mode would you like to play? (<easy>, <medium>, <hard>: Default is <easy>');
	window.location = 'endless.php?d=' + String(ans);
}
</script>
<style>
html, body{
position: absolute;
height: 100%;
width: 100%;
left: 0px;
top: 0px;
background: #76b852; /* fallback for old browsers */
  	background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  	background: -moz-linear-gradient(right, #76b852, #8DC26F);
  	background: -o-linear-gradient(right, #76b852, #8DC26F);
  	background: linear-gradient(to left, #76b852, #8DC26F);
}
.topbar{
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 64px;
	background: white;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.box{
	display: flex;
	justify-content: center;
	align-items: center;
	position: absolute;
	height: 50%;
	width: 46%;
	margin: 1%;
	top: 25%;
	font-size: 5vw;
	color: gray;
	text-align: center;
	background: white;
	border-radius: 16px;
	box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.boxRight:hover{
	width: 50%;
	height: 52%;
	z-index: 1;
	top: 24%;
}
.boxLeft:hover{
	width: 50%;
	height: 52%;
	z-index: 1;
	left: 45%;
	top: 24%;
}
</style>
</html>
