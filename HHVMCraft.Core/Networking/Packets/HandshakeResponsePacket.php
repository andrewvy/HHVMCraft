<?php

namespace HHVMCraft\Core\Networking\Packets;

class HandshakeResponsePacket {
	const id = "02";
	public $connectionHash;

	public function __construct($connectionHash="") {
		$this->connectionHash = $connectionHash;
	}

	public function readPacket($StreamWrapper) {
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt16(self::id).
			$StreamWrapper->writeUInt16(strlen($this->connectionHash)).
			$StreamWrapper->writeString16($this->connectionHash);

		return $StreamWrapper->writePacket($str);
	}
}
