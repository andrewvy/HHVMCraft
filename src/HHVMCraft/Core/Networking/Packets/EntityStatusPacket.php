<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class EntityStatusPacket {
	const id = 0x26;
	public $entity_id;
	public $entity_status;

	public function __construct($entity_id, $entity_status) {
		$this->entity_id = $entity_id;
		$this->entity_status = $entity_status;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entity_id) .
		$StreamWrapper->writeInt8($this->entity_status);

		return $StreamWrapper->writePacket($p);
	}
}
