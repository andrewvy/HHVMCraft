<?php

namespace HHVMCraft\Core\Networking\Handlers;

require "HHVMCraft.Core/Networking/Packets/HandshakeResponsePacket.php";
require "HHVMCraft.Core/Networking/Packets/LoginResponsePacket.php";

use HHVMCraft\Core\Networking\Packets;

class LoginHandler {

	public static function HandleHandshakePacket($packet, $client, $server) {
		$client->Username = $packet->username;
		$client->enqueuePacket(new Packets\HandshakeResponsePacket("-"));
	}

	public static function HandleLoginRequestPacket($packet, $client, $server) {
		// new Packets\LoginResponsePacket("----");	
	}
}
