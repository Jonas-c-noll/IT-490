<html>
<?php
for($c = 0; $c <= 4; $c++){
	$category = $c + 1;
	$curl = curl_init('http://www.jservice.io/api/category?id='.$category);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($curl);
	curl_close($curl);
	$formatted = strstr($result, '[');
	//echo $result;
	$formatted = substr($formatted, 0, -1);
	//echo $formatted;
	$json_a[$c] = json_decode($formatted, true);
	for($i = 0; $i <= 10; $i++){
    		echo "<br><br>Question: " .  $json_a[$c][$i]['question'] . " Answer: " . $json_a[$i]['answer'];
	}
	echo "<br><br>";
}
/*$curl = curl_init('http://www.jservice.io/api/category?id=2');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
curl_close($curl);
$formatted = strstr($result, '[');
//echo $result;
$formatted = substr($formatted, 0, -1);
echo $formatted;
//echo $result;
/*$arr = explode(PHP_EOL, $result);
//foreach($arr as $line){
  //  $json_a[]= json_decode($line, true);
//}
//Var_dump($json_a);
$json_a = json_decode($formatted, true);
for($i = 0; $i <= 10; $i++){
    echo "<br><br>Question: " .  $json_a[$i]['question'] . " Answer: " . $json_a[$i]['answer'];
}*/
?>

