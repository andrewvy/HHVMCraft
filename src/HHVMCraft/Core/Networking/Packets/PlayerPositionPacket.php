<?php

namespace HHVMCraft\Core\Networking\Packets;

class PlayerPositionPacket {
	const id = "0b";

	public $x;
	public $y;
	public $stance;
	public $z;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->x = floatval($StreamWrapper->readDouble());
		$this->y = floatval($StreamWrapper->readDouble());
		$this->stance = floatval($StreamWrapper->readDouble());
		$this->z = floatval($StreamWrapper->readDouble());
		$this->onGround = $StreamWrapper->readBool();
	}

}
