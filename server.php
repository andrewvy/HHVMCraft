<?php

error_reporting(E_ERROR);
require "HHVMCraft.Core/Networking/MultiplayerServer.php";
use HHVMCraft\Core\Networking\MultiplayerServer;

echo " >> Starting Server \n";

$addr = "127.0.0.01";
$server = new MultiplayerServer($addr);

$server->start(25565);
