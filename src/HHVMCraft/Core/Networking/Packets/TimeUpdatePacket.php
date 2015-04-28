<?php

namespace HHVMCraft\Core\Networking\Packets;

class TimeUpdatePacket {
	const id = "04";
	public $time;

	public function __construct($time) {
		$this->time = $time;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeLong($this->time);

		return $StreamWrapper->writePacket($str);
	}
}
