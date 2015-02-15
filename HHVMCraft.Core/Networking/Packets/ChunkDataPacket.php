<?php

namespace HHVMCraft\Core\Networking\Packets;

class ChunkDataPacket {
	const id = "33";
	
	public $x;
	public $y;
	public $z;

	public $Width;
	public $Height;
	public $Depth;
	public $BlockData;

	public function __construct($x, $y, $z, $Width, $Height, $Depth, $BlockData) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $y;
		$this->Width = $Width;
		$this->Height = $Height;
		$this->Depth = $Depth;	
		$this->BlockData = $BlockData;
	}

	public writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt($this->x).
			$StreamWrapper->writeUInt16($this->y).
			$StreamWrapper->writeInt($this->z).
			$StreamWrapper->writeUInt8($this->Width).
			$StreamWrapper->writeUInt8($this->Height).
			$StreamWrapper->writeUInt8($this->Depth).
			$StreamWrapper->writeInt(strlen($this->BlockData)).
			$StreamWrapper->writeUInt8Array($this->BlockData);
		
		return $StreamWrapper->writePacket($str);
	}
}
