<?php

namespace HHVMCraft\Core\Networking\Packets;

class SpawnPositionPacket {
	const id = "06";
	public $x;
	public $y;
	public $z;

	public function __construct($x, $y, $z) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeInt($this->x).
			$StreamWrapper->writeInt($this->y).
			$StreamWrapper->writeInt($this->z);
	
		return $StreamWrapper->writePacket($str);
	}
}
