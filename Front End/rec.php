<?php
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
include 'pingserver.php';
$username = $_POST['username'];
$queue =  $_POST['queue'];
//$queue = "login";
$connection = new AMQPStreamConnection(find(), 5672, 'admin', 'IT490password');
$channel = $connection->channel();

$channel->queue_declare($queue, false, false, false, false);

//echo " [*] Waiting for messages.<p>\n";

$callback = function ($msg) {
    echo $msg->body;
    $_SESSION['score'] = $msg->body;
    
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

//while (count($channel->callbacks)) {
    $channel->wait();
//}

$channel->close();
$connection->close();
?>



