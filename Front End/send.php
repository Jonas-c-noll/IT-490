<?php 
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include 'pingserver.php';
$username = $_POST['username'];
$_SESSION['username'] = $username;
$password = $_POST['password'];
$password = md5($password);
$cat = $_POST['cat'];
//$hash = password_hash($password, PASSWORD_DEFAULT);
$hash = $password; 
$queue =  $_POST['queue'];
$message = $_POST['msg'];
if($queue == "auth"){
	$body = '{ "username" : "'.$username.'" , "password" : "'.$hash.'"}';
}
if($queue == "reg"){
	$body = '{ "username":"'.$username.'", "password":"'.$hash.'", "highscore" : "0"}';
}
if($queue == "http1"){
	$body = $cat;
}
$connection = new AMQPStreamConnection(find(), 5672, 'admin', 'IT490password');
$channel = $connection->channel();

$channel->queue_declare($queue, false, false, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = $body;
}

$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);
$channel->basic_publish($msg, '', $queue);

echo " [x] Sent $data , $queue\n";

$channel->close();
$connection->close();


// { user : username , username : password }
