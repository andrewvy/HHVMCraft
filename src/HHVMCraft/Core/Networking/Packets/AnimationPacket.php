<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class AnimationPacket {
	const id = 0x12;

	public $eid;
	public $animate;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();
		$this->animate = $StreamWrapper->readInt8();
	}

}
