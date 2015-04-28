<?php

namespace HHVMCraft\Core\Networking\Packets;

class ChatMessagePacket {
	const id = "03";
	public $message;

	public function __construct($message) {
		$this->message = $message;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeUInt16(strlen($this->message)).
			$StreamWrapper->writeString16($this->message);

		return $StreamWrapper->writePacket($str);
	}

	public function readPacket($StreamWrapper) {
		$this->message = $StreamWrapper->readString16();
	}
}
