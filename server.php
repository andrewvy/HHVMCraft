<?php

require 'HHVMCraft.Core/Networking/MultiplayerServer.php';

print " >> Starting Server..";

$server = new \HHVMCraft\Core\Networking\MultiplayerServer($addr);

$server->start(25565);

$server->onConnect = function ($client) {
	echo "GOT CLIENT";
};
