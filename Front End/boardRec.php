<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//$result = "\n\n\n\n\n\nyep";
function genRec($cat){
	//SEND
	//-----------------------------------------------
	$connection = new AMQPStreamConnection("192.168.10.50", 5672, 'admin', 'IT490password');
	$channel = $connection->channel();

	$body = $cat;
	//$body = file_get_contents("json.txt");
	$queue = "http1";

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

	//------------------------------------------------

	$queue = "http2";

	$channel->queue_declare($queue, false, false, false, false);

	//echo " [*] Waiting for messages.\n";

	$callback = function ($msg) {
	    file_put_contents('buffer.json', json_encode($msg->body));
	    //$result = json_encode($msg->body);
	    //echo $result;
	};

	$channel->basic_consume($queue, '', false, true, false, false, $callback);

	//while (count($channel->callbacks)) {
	    $channel->wait();
	//}

	$channel->close();
	$connection->close();
}
//genRec();
?>



