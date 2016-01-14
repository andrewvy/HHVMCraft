<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class SpawnPlayerPacket {
	const id = 0x14;
	public $entityId;
	public $playerName;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $pitch;
	public $currentItem;

	public function __construct($entityId, $playerName, $x, $y, $z, $yaw, $pitch, $currentItem) {
		$this->entityId = $entityId;
		$this->playerName = $playerName;
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->yaw = $yaw;
		$this->pitch = $pitch;
		$this->currentItem = $currentItem;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entityId) .
		$StreamWrapper->writeInt16(strlen($this->playerName)) .
		$StreamWrapper->writeString16($this->playerName) .
		$StreamWrapper->writeInt($this->x) .
		$StreamWrapper->writeInt($this->y) .
		$StreamWrapper->writeInt($this->z) .
		$StreamWrapper->writeInt8($this->yaw) .
		$StreamWrapper->writeInt8($this->pitch) .
		$StreamWrapper->writeInt16($this->currentItem);

		return $StreamWrapper->writePacket($str);
	}
}
