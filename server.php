<?php

require "HHVMCraft.Core/Networking/MultiplayerServer.php";
use HHVMCraft\Core\Networking\MultiplayerServer;

echo " >> Starting Server";

$addr = "127.0.0.01";
$server = new MultiplayerServer($addr);

$server->start(25565);

/*

$server = stream_socket_server("tcp://127.0.0.1:25565", $errno, $errorMsg);

if ($server === false) {
	throw new UnexpectedValueException("Could not bind to socket: $errorMsg");
}

for (;;) {
	$client = @stream_socket_accept($server);
	if ($client) {
		print "new client!";
		$buf = "buffer";
		socket_write($client, $buf);	
		socket_close($client);
	}
}
*/
