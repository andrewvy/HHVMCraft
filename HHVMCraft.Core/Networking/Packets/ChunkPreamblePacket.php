<?php

namespace HHVMCraft\Core\Networking\Packets;

class ChunkPreamblePacket {
	const id = "32";
	public $x;
	public $z;
	public $load;

	public function __construct($x, $z, $load=true) {
		$this->x = $x;
		$this->z = $z;
		$this->load = $load;	
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt($this->x).
			$StreamWrapper->writeInt($this->z).
			$StreamWrapper->writeBool($this->load);	

		return $StreamWrapper->writePacket($str);
	}
}
