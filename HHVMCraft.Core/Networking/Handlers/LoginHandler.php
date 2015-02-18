<?php

namespace HHVMCraft\Core\Networking\Handlers;

require "HHVMCraft.Core/Networking/Packets/HandshakeResponsePacket.php";
require "HHVMCraft.Core/Networking/Packets/LoginResponsePacket.php";
require "HHVMCraft.Core/Networking/Packets/WindowItemsPacket.php";
require "HHVMCraft.Core/Networking/Packets/SpawnPositionPacket.php";
require "HHVMCraft.Core/Networking/Packets/SetPlayerPositionPacket.php";
require "HHVMCraft.Core/Networking/Packets/TimeUpdatePacket.php";

require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\Packets\HandshakeResponsePacket;
use HHVMCraft\Core\Networking\Packets\LoginResponsePacket;
use HHVMCraft\Core\Networking\Packets\WindowItemsPacket;

class LoginHandler {

	public static function HandleHandshakePacket($packet, $client, $server) {
		$client->username = $packet->username;

		$client->enqueuePacket(new HandshakeResponsePacket("-"));
	}

	public static function HandleLoginRequestPacket($packet, $client, $server) {
		if ($packet->protocolVersion == 14) {

			// Respond with details about the world.
			$client->enqueuePacket(new LoginResponsePacket(0, 0, 0));
				
			// Creating player entity..
			$client->PlayerEntity = $server->EntityManager->addPlayerEntity($client);

			// Handle client inventory.. (WindowItemPacket)
			$client->enqueuePacket(new WindowItemsPacket(0, $client->Inventory->getSlots()));
			$client->Entity->Position = $client->World->ChunkProvider->spawnpoint;

			// Handle client entity spawnpoint.. (SpawnPositionPacket)
			// Handle player position (SetPlayerPositionPacket)
			// Handle client time (TimeUpdatePacket)

			// Add player entity to entitymanager, subscribe client to entities.
		} else {
			throw new \Exception("Wrong version!");
		}
	}
}
