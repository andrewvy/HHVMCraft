<?php

namespace HHVMCraft\Core\Networking;

use HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Networking\Handlers\LoginHandler;

class PacketHandler {

	public static function registerHandlers($server) {
		$server->registerPacketHandler(new Packets\HandshakePacket().ID, LoginHandlers.HandleHandshakePacket);
		$server->registerPacketHandler(new Packets\LoginRequestPacket().ID, LoginHandlers.HandleLoginRequestPacket);
	}

}
