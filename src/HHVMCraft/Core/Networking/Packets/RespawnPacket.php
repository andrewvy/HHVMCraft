<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class RespawnPacket {
	const id = 0x09;
	public $world;

	public function __construct($world=0x00) {
		$this->world = $world;
	}

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->world = $StreamWrapper->readInt8();
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt8($this->world);

		return $StreamWrapper->writePacket($str);
	}
}
