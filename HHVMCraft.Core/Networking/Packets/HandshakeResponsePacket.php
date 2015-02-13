<?php

namespace HHVMCraft\Core\Networking\Packets;

class HandshakeResponsePacket {
	const id = 0x02;
	public $connectionHash;

	public function __construct($connectionHash="") {
		$this->connectionHash = $connectionHash;
	}

	public function readPacket($stream) {
		$stream->readUInt8();
	}
}
