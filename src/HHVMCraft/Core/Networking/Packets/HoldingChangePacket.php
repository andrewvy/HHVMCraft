<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class HoldingChangePacket {
	const id = 0x10;
	public $slotid;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->slotid = $StreamWrapper->readInt16();
	}

}
