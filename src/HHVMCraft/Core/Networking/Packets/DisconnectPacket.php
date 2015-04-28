<?php

namespace HHVMCraft\Core\Networking\Packets;

class DisconnectPacket {
	const id = "ff";
	public $reason;

	public function __construct($reason) {
		$this->reason = $reason;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeUInt16(strlen($this->reason)).
			$StreamWrapper->writeString16($this->reason);

		return $StreamWrapper->writePacket($str);
	}

	public function readPacket($StreamWrapper) {
		$this->reason = $StreamWrapper->readString16();
	}
}
