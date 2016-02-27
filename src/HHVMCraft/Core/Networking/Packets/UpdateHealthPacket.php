<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class UpdateHealthPacket {
	const id = 0x08;
	public $health;

	public function __construct($health=0) {
		$this->health = $health;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt16($this->health);

		return $StreamWrapper->writePacket($p);
	}
}
