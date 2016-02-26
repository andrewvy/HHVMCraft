<?php

namespace HHVMCraft\Core\Networking\Handlers;

use HHVMCraft\API\Coordinates3D;
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
		// DIRECTION
		//  0    1   2   3   4   5
		//  -Y	+Y	-Z	+Z	-X	+X

		$direction = $Packet->direction;
		$x = $Packet->x;
		$y = $Packet->y;
		$z = $Packet->z;

		switch ($direction) {
			case 0:
				$y--;
				break;
			case 1:
				$y++;
				break;
			case 2:
				$z--;
				break;
			case 3:
				$z++;
				break;
			case 4:
				$x--;
				break;
			case 5:
				$x++;
				break;
			default:
				return 0;
		}

		$Coordinates3D = new Coordinates3D($x, $y, $z);

		if ($Packet->blockid == 0xFFFF) {
			return $Server->sendMessage("Use item not implemented yet!");
		}

		if (!$Server->EntityManager->checkForBlockingEntities($Coordinates3D)) {
			$Server->World->setBlockID($Coordinates3D, $Packet->blockid);
			$broadcastPacket = new BlockChangePacket($x, $y, $z, $Packet->blockid, 0x00);
			$Server->broadcastPacket($broadcastPacket);
		}
	}

	public static function HandleDigging($Packet, $Client, $Server) {
		$status = $Packet->status;
		$x = $Packet->x;
		$y = $Packet->y;
		$z = $Packet->z;

		$coords = new Coordinates3D($x, $y, $z);

		$face = $Packet->face;

		switch ($status) {
			case 0:
				return 0;
				break;
			case 2:
				$slot_index = $Client->Inventory->findEmptySpace();

				// Translate block coordinates to chunk coordinates
				// Fetch the chunk that contains that block coords
				// Get the block id from the chunk
				// Find empty space where we can increment or add w/ the block id
				// Update the player inventory with the block id

				if ($slot_index > -1) {
				}

				$Server->World->setBlockID($coords, 0x00);
				$broadcastPacket = new BlockChangePacket($x, $y, $z, 0x00, 0x00);
				$Server->broadcastPacket($broadcastPacket);
				break;
			case 4:
				return 0;
				break;
			default:
				return 0;
		}
	}
}
