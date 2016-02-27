<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class HandshakeResponsePacket {
	const id = 0x02;
	public $connectionHash;

	public function __construct($connectionHash = "") {
		$this->connectionHash = $connectionHash;
	}

	public function readPacket(StreamWrapper $StreamWrapper) {
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt16(strlen($this->connectionHash)) .
		$StreamWrapper->writeString16($this->connectionHash);

		return $StreamWrapper->writePacket($str);
	}
}
