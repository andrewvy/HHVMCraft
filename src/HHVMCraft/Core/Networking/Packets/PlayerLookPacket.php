<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PlayerLookPacket {
	const id = 0x0C;

	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->yaw = $StreamWrapper->readInt();
		$this->pitch = $StreamWrapper->readInt();
		$this->onGround = $StreamWrapper->readBool();
	}
}
