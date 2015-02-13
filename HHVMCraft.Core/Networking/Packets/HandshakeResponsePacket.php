<?php

namespace HHVMCraft\Core\Networking\Packets;

class HandshakeResponsePacket {
	const id = "02";
	public $connectionHash;

	public function __construct($connectionHash="") {
		$this->connectionHash = $connectionHash;
	}

	public function readPacket($StreamWrapper) {
		$this->connectionHash = $StreamWrapper->readString16();
	}

	public function writePacket($stream) {
	
	}
}
