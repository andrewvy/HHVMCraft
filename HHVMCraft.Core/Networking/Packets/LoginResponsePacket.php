<?php

namespace HHVMCraft\Core\Networking\Packets;

class LoginResponsePacket {
	const id = "01";
	public $Dimension;
	public $EntityID;
	public $Seed;

	public function __construct($entityID, $seed, $dimension) {
		$this->EntityID = $entityID;
		$this->Seed = $seed;
		$this->Dimension = $dimension;
	}

	public function writePacket($StreamWrapper) {
		$p = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeInt($this->EntityID).
			$StreamWrapper->writeUInt16(0).
			$StreamWrapper->writeLong($this->Seed).
			$StreamWrapper->writeUInt8($this->Dimension);

		return $StreamWrapper->writePacket($p);
	}
}
