<?php

use HHVMCraft\Core\Networking\MultiplayerServer;

print " >> Starting Server";

$server = new MultiplayerServer($addr);

$server->start(25565);

$server->onConnect = function ($client) {
	print " >> GOT CLIENT";
};
