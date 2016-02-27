<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PlayerGroundedPacket {
	const id = 0x0A;
	public $onGround;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->onGround = $StreamWrapper->readInt8();
	}
}
