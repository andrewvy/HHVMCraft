<?php

namespace HHVMCraft\Core\Networking\Packets;

class PlayerGroundedPacket {
	const id = "0a";
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->onGround = $StreamWrapper->readBool();
	}
}
