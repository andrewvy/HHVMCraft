<?php

namespace HHVMCraft\Core\Networking;

require "Packets/HandshakePacket.php";
require "Packets/LoginRequestPacket.php";

use HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Networking\Handlers\LoginHandler;

class PacketHandler {

	public static function registerHandlers($server) {
		$server->registerPacketHandler(new Packets\HandshakePacket(), LoginHandlers.HandleHandshakePacket);
		$server->registerPacketHandler(new Packets\LoginRequestPacket(), LoginHandlers.HandleLoginRequestPacket);
	}

}
