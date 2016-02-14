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
use HHVMCraft\Core\Networking\Packets\BlockChangePacket;

class PlayerHandler {

	public static function HandleGrounded() {
	}

	public static function HandlePosition($packet, $client, $server) {
		// TODO (vy): Actually do server-side checking for position
		$client->PlayerEntity->Position->x = $packet->x;
		$client->PlayerEntity->Position->y = $packet->y;
		$client->PlayerEntity->Position->z = $packet->z;
	}

	public static function HandleLook($Packet, $Client, $Server) {
		$Client->PlayerEntity->Position->pitch = $Packet->pitch;
		$Client->PlayerEntity->Position->yaw = $Packet->yaw;
	}

	public static function HandlePositionAndLook($Packet, $Client, $Server) {
		$Client->PlayerEntity->Position->x = $Packet->x;
		$Client->PlayerEntity->Position->y = $Packet->y;
		$Client->PlayerEntity->Position->z = $Packet->z;
		$Client->PlayerEntity->Position->pitch = $Packet->pitch;
		$Client->PlayerEntity->Position->yaw = $Packet->yaw;
	}

	public static function HandleRespawn($Packet, $Client, $Server) {
		$spawnpoint = $Client->World->ChunkProvider->spawnpoint;

		$Client->enqueuePacket(new SetPlayerPositionPacket(
			$spawnpoint->x,
			$spawnpoint->y,
			$spawnpoint->y + PlayerEntity::Height,
			$spawnpoint->z,
			0,
			0,
			true)
		);

		$Client->enqueuePacket(new RespawnPacket());
	}

	public static function HandleBlockPlacement($Packet, $Client, $Server) {
		$broadcastPacket = new BlockChangePacket($Packet->x, $Packet->y, $Packet->z, $Packet->blockid, 0x00);

		$Server->broadcastPacket($broadcastPacket);
	}
}
