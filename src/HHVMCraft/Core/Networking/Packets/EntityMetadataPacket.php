<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class EntityMetadataPacket {
	const id = 0x28;

	public $eid;
	public $metadata;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();

		// TODO (vy): Implement metadata parsing..
	}
}
