<?php
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
include 'pingserver.php';
$username = $_POST['username'];
$connection = new AMQPStreamConnection(find(), 5672, 'admin', 'IT490password');
$channel = $connection->channel();

$channel->queue_declare("recfriend", false, false, false, false);

$callback = function ($msg) {
    echo $msg->body;
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

//while (count($channel->callbacks)) {
    $channel->wait();
//}

$channel->close();
$connection->close();
?>



