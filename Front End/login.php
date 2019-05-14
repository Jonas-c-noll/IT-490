<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$username = $_POST['username'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT); 
$queue =  $_POST['queue'];
$message = $_POST['msg'];
$body = '{ "username" : "'.$username.'" , "password" : "'.$hash.'"}';

$connection = new AMQPStreamConnection('henry-pc', 5672, 'admin', 'IT490password');
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

echo " [x] Sent $data\n";

$channel->close();
$connection->close();


// { user : username , username : password }
