<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PlayerPositionAndLookPacket {
	const id = 0x0D;

	public $x;
	public $y;
	public $stance;
	public $z;
	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->x = $StreamWrapper->readDouble();
		$this->y = $StreamWrapper->readDouble();
		$this->stance = $StreamWrapper->readDouble();
		$this->z = $StreamWrapper->readDouble();
		$this->yaw = $StreamWrapper->readInt();
		$this->pitch = $StreamWrapper->readInt();
		$this->onGround = $StreamWrapper->readBool();
	}
}
