<?php

namespace HHVMCraft\Core\Networking\Handlers;

require "HHVMCraft.Core/Networking/Packets/HandshakeResponsePacket.php";
require "HHVMCraft.Core/Networking/Packets/LoginResponsePacket.php";

use HHVMCraft\Core\Networking\Packets;

class LoginHandler {

	public static function HandleHandshakePacket($packet, $client, $server) {
		$client->username = $packet->username;
		echo $client->username;
	}

	public static function HandleLoginRequestPacket($packet, $client, $server) {
		// new Packets\LoginResponsePacket("----");	
	}
}
