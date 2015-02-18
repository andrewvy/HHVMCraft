<?php

namespace HHVMCraft\Core\Networking\Packets;

class DestroyEntityPacket {
	const id = "id";
	public $entityId;

	public function __construct($entityId) {
		$this->entityId = $entityId;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeInt($this->entityId);

		return $StreamWrapper->writePacket($str);
	}

}
