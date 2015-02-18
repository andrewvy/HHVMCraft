<?php

namespace HHVMCraft\Core\Networking\Packets;

class PlayerPositionAndLookPacket {
	const id = "0d";

	public $x;
	public $y;
	public $stance;
	public $z;
	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->x = $StreamWrapper->readDouble();
		$this->y = $StreamWrapper->readDouble();
		$this->stance = $StreamWrapper->readDouble();
		$this->z = $StreamWrapper->readDouble();
		$this->yaw = $StreamWrapper->readUInt8();
		$this->pitch = $StreamWrapper->readUInt8();
		$this->onGround = $StreamWrapper->readBool();
	}
}
