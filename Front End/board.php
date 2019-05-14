<html>
<head>
<script src ="jquery.min.js"></script>
</head>
<body>
<div id="players"><div id="One" style="left: 0px;"><b>Player 1:</b> </div><div id="Two" style="left: 25%;"><b>Player 2:</b></div><div id="Three" style="left: 50%;"><b>Player 3:</b></div><div id="Four" style="left: 75%;"><b>Player 4:</b></div></div>
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
<?php
include "boardRec.php";
function getScriptOutput($path, $var, $print = FALSE)
{
    ob_start();
    $category = $var;
    if( is_readable($path) && $path )
    {
        include $path;
    }
    else
    {
        return FALSE;
    }

    if( $print == FALSE )
        return ob_get_clean();
    else
        echo ob_get_clean();
}

function fix($value){
$result  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$value);
		
return $result;
}

for($c = 0; $c <= 4; $c++){
	//Offset for the category ID: Most offsets < 1000 don't have full games available.
	$gameSeed = rand(1000, 5000);
	//$c is the offset for each category from the main seed: IE the first collumn could be ID 20, then the second column is 21, next is 22, etc.
	$category = $c + $gameSeed;

	///!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\
	//For testing purposes only--/!\
	//$curl = curl_init('http://www.jservice.io/api/category?id='.$category);
	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//$result = curl_exec($curl);
	//curl_close($curl);
	///!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\
	
	//$path = 'boardRec.php';
	//$result = getScriptOutput($path, $category);
	genRec($category);
	$result = json_decode(file_get_contents("buffer.json"));
	//echo "result: \n" . $result . "end result \n";
	//echo "<script> alert('".$result."'); </script>";

	if( $result === FALSE)
	{
   	 	echo "fuuuuuck";
	}	
	else
	{
	   	//Formats the returned json for easier parsing:
		//--------------------------------------------
		$cat[$c] = strstr($result, '"title":"'); 		//
		$cat[$c] = substr($cat[$c], 0, strpos($cat[$c], ','));	//
		$cat[$c] = substr($cat[$c], 8);				//
		$formatted = strstr($result, '[');
		$formatted = substr($formatted, 0, -1);
		//echo $formatted;
		//echo "<script type='text/javascript'>alert('letssee');</script>";
		//echo "<script type='text/javascript'>alert('".var_dump($formatted)."');</script>";
		//--------------------------------------------
		//For Each Category: Decodes JSON for use with the game. 5 Questions/AnswerCombos each
		$json_a[$c] = json_decode($formatted, true);
		//echo "<script type='text/javascript'>alert('".var_dump($json_a)."');</script>";
	}
}

//GAMEBOARD:
//------------------------------------------------
for($i = 0; $i <= 4; $i++){ //Columns
	for($j = 0; $j<=4; $j++){ //Rows
		//Instantiating Game:
		//Category boxes: 20% x 32px large.
		echo '<div id="box" id="category" style="position:absolute; z-index:11; width:19%; height:32px; top:-32px; left:' . 20 * $i . '%; background: blue;">' .  $cat[$i] . '</div>';	
		//Question boxes:
		//Values:
		echo '<div id="box" onClick="hideBox(this)" style="position:absolute; z-index:11; width:19%; height:19%; top:' . 20 * $j .'%; left:' . 20 * $i . '%; background: blue;">' . 200 * ($j + 1)  . '</div>';	
		//Questions:
		echo '<div id="box" onClick="hideBox(this)" style="position:absolute; z-index:10; width:19%; height:19%; top:' . 20 * $j .'%; left:' . 20 * $i . '%; background: blue;">Question: ' . $json_a[$i][$j]['question'] . " : " . $json_a[$i][$j]['answer'] .'<div style="text-align: center;">
<div style="position: absolute; left: 0px; top: 75%; height: 25%; width: 25%; z-index:11; border:1px solid white; background: green;" onClick="add(0, '. 200 * (1 + $j) . ", '" . $json_a[$i][$j]['answer'] . '\')">1</div>
<div style="position: absolute; left: 25%; top: 75%; height: 25%; width: 25%; z-index:11; border:1px solid white; background: green;" onClick="add(1, '. 200 * (1 + $j) . ", '" . $json_a[$i][$j]['answer'] . '\')">2</div>
<div style="position: absolute; left: 50%; top: 75%; height: 25%; width: 25%; z-index:11; border:1px solid white; background: green;" onClick="add(2, '. 200 * (1 + $j) . ", '" . $json_a[$i][$j]['answer'] . '\')">3</div>
<div style="position: absolute; left: 75%; top: 75%; height: 25%; width: 25%; z-index:11; border:1px solid white; background: green;" onClick="add(3, '. 200 * (1 + $j) . ", '" . $json_a[$i][$j]['answer'] . '\')">4</div></div></div>';	
		//Answers
		echo '<div id="box" onClick="hideBox(this)" style="position:absolute; z-index:9; width:19%; height:19%; top:' . 20 * $j .'%; left:' . 20 * $i . '%; background: blue;">Answer: ' .  $json_a[$i][$j]['answer'] . '</div>';
	}
}
//------------------------------------------------
?>
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
	width: 25%;
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
