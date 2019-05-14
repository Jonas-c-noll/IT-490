<?php 
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include 'pingserver.php';
$username = $_POST['username'];
$friend = $_POST['friend'];
// { user : username , username : password }
$queue = "fry";
$body = '{ "username" : "'.$username.'" , "friend" : "'.$friend.'" }';
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

echo " [x] Sent $data , $queue";

$channel->close();
$connection->close();
?>
