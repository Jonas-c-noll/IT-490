<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//SEND
//-----------------------------------------------
//$connection = new AMQPStreamConnection('192.168.10.50', 5672, 'admin', 'IT490password');
$category = $_POST['category'];
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'IT490password');
$channel = $connection->channel();

$body = $category;
$queue = "http2";

$channel->queue_declare($queue, false, false, false, false);

//$data = implode(' ', array_slice($argv, 1));
//if (empty($data)) {
    $data = $body;
//}

$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);
$channel->basic_publish($msg, '', $queue);

//echo " [x] Sent $data\n";

$channel->close();
$connection->close();

?>
