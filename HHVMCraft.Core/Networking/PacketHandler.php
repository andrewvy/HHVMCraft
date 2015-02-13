<?php

namespace HHVMCraft\Core\Networking;

require "Packets/HandshakePacket.php";
require "Packets/LoginRequestPacket.php";
require "Handlers/LoginHandler.php";

use HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Networking\Handlers;

class PacketHandler {

	public static function registerHandlers($server) {
		$server->registerPacketHandler(new Packets\HandshakePacket, 'Handlers\LoginHandlers::HandleHandshakePacket');
		$server->registerPacketHandler(new Packets\LoginRequestPacket, 'Handlers\LoginHandler::HandleLoginRequestPacket');
	}

}
