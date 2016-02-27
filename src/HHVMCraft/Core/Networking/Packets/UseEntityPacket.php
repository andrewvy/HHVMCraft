<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class UseEntityPacket {
	const id = 0x07;

	public $user;
	public $target;
	public $leftclick;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->user = $StreamWrapper->readInt();
		$this->target = $StreamWrapper->readInt();
		$this->leftclick = $StreamWrapper->readInt8();
	}

}
