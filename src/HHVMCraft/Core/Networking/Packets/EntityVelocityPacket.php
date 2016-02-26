<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

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

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entityId) .
		$StreamWrapper->writeInt16($this->xVel) .
		$StreamWrapper->writeInt16($this->yVel) .
		$StreamWrapper->writeInt16($this->zVel);

		return $StreamWrapper->writePacket($str);
	}
}
