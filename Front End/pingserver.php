<?php
function find() {
    $addresses = [
	1 => "henry-pc",
	2 => "henry-pc2",
    ];
    foreach ($addresses as $ip){
    	$pingresult = exec("/bin/ping -c 1 $ip", $outcome, $status);
    	if (0 == $status) {
	    return $ip;
	    break;
	}
	else{
	    echo "Server not found: IP: " . $ip . " Response: " . $outcome . " ";	
	}
    }
}
find();
?>

