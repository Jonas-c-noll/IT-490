<?php
session_start();
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
include "pingserver.php";
$curscore = $_POST['curscore'];
if($curscore == 0){
	$_SESSION['curscore'] = $curscore;
}
else{
	$_SESSION['curscore'] = $_SESSION['curscore'] + $curscore;
	if($_SESSION['curscore'] > $_SESSION['score']){
		$_SESSION['score'] = $_SESSION['curscore'];
		$queue =  "scoreup";
		$body = '{ "username" : "' . $_SESSION['username']. '", "score" : "' . $_SESSION['score'] .'" }';
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

		echo "New High Score! : " . $body;

		$channel->close();
		$connection->close();
	}	
}
echo "New Score:: " . $_SESSION['curscore'];
?>
