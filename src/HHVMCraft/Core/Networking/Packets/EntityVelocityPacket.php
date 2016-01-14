<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class EntityVelocityPacket {
	const id = 0x1c;
	public $entityId;
	public $xVel;
	public $yVel;
	public $zVel;

	public function __construct($entityId, $xVel, $yVel, $zVel) {
		$this->entityId = $entityId;
		$this->xVel = $xVel;
		$this->yVel = $yVel;
		$this->zVel = $zVel;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entityId) .
		$StreamWrapper->writeInt16($this->xVel) .
		$StreamWrapper->writeInt16($this->yVel) .
		$StreamWrapper->writeInt16($this->zVel);

		return $StreamWrapper->writePacket($str);
	}
}
