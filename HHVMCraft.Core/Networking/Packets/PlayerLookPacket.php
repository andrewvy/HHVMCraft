<?php

namespace HHVMCraft\Core\Networking\Packets;

class PlayerLookPacket {
	const id = "0c";

	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->yaw = $StreamWrapper->readInt();
		$this->pitch = $StreamWrapper->readInt();
		$this->onGround = $StreamWrapper->readBool();
	}
}
