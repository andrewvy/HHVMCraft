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
		$this->x = $StreamWrapper->readDouble();
		$this->y = $StreamWrapper->readDouble();
		$this->stance = $StreamWrapper->readDouble();
		$this->z = $StreamWrapper->readDouble();
		$this->onGround = $StreamWrapper->readBool();
	}

}
