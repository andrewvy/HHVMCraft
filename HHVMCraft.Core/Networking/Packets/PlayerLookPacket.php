<?php

namespace HHVMCraft\Core\Networking\Packets;

class PlayerLookPacket {
	const id = "0c";

	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->yaw = $StreamWrapper->readUInt8();
		$this->pitch = $StreamWrapper->readUInt8();
		$this->onGround = $StreamWrapper->readBool();
	}
}
