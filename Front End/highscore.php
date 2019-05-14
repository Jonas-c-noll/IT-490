<?php
session_start();
//echo "User: " . $_SESSION['username'];
?>
<html>
<head>
</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include "pingserver.php";
//$result = "\n\n\n\n\n\nyep";
//SEND
//-----------------------------------------------
$connection = new AMQPStreamConnection(find(), 5672, 'admin', 'IT490password');
$channel = $connection->channel();

$body = 'potato';

$queue = "highscores";

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

echo "Leaderboard: <br>";

//------------------------------------------------

$queue = "highscore";

$channel->queue_declare($queue, false, false, false, false);

//echo " [*] Waiting for messages.\n";

$callback = function ($msg) {
    $result = $msg->body;
    $result = str_replace("'Highscores'", '<br>', $result);
    $result = str_replace(",", "", $result);
    $result = str_replace("' ", "' : ", $result);
    $result = str_replace("(", "", $result);
    $result = str_replace(")", "", $result);
    echo $result;
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

//while (count($channel->callbacks)) {
    $channel->wait();
//}

$channel->close();
$connection->close();
//genRec();
?>
</body>



