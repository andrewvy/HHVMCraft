<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Handlers;

use HHVMCraft\Core\Entities\PlayerEntity;
use HHVMCraft\Core\Networking\Packets\SetPlayerPositionPacket;
use HHVMCraft\Core\Networking\Packets\RespawnPacket;

class PlayerHandler {

	public static function HandleGrounded() {
	}

	public static function HandlePosition($packet, $client, $server) {
		// TODO (vy): Actually do server-side checking for position
		$client->PlayerEntity->Position->x = $packet->x;
		$client->PlayerEntity->Position->y = $packet->y;
		$client->PlayerEntity->Position->z = $packet->z;
	}

	public static function HandleLook() {
	}

	public static function HandlePositionAndLook() {
	}

	public static function HandleRespawn($Packet, $Client, $Server) {
		$Client->PlayerEntity->Position = $Client->World->ChunkProvider->spawnpoint;
		$Client->enqueuePacket(new SetPlayerPositionPacket(
			$Client->PlayerEntity->Position->x,
			$Client->PlayerEntity->Position->y,
			$Client->PlayerEntity->Position->y + PlayerEntity::Height,
			$Client->PlayerEntity->Position->z,
			0,
			0,
			true)
		);

		$Client->enqueuePacket(new RespawnPacket());
	}
}
