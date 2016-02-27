<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class DestroyEntityPacket {
	const id = 0x1D;
	public $entityId;

	public function __construct($entityId) {
		$this->entityId = $entityId;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entityId);

		return $StreamWrapper->writePacket($str);
	}

}
