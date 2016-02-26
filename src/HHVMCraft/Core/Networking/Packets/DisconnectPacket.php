<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class DisconnectPacket {
	const id = 0xFF;
	public $reason;

	public function __construct($reason="") {
		$this->reason = $reason;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt16(strlen($this->reason)) .
		$StreamWrapper->writeString16($this->reason);

		return $StreamWrapper->writePacket($str);
	}

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->reason = $StreamWrapper->readString16();
	}
}
