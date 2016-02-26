<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class EntityTeleportPacket {
	const id = 0x22;
	public $entityId;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $pitch;

	public function __construct($entityId, $x, $y, $z, $yaw, $pitch) {
		$this->entityId = $entityId;
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->yaw = $yaw;
		$this->pitch = $pitch;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->x) .
		$StreamWrapper->writeInt($this->y) .
		$StreamWrapper->writeInt($this->z) .
		$StreamWrapper->writeInt8($this->yaw) .
		$StreamWrapper->writeInt8($this->pitch);

		return $StreamWrapper->writePacket($str);
	}
}
