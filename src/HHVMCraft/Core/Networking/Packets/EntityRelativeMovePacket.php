<?php
/**
* This file is part of HHVMCraft - a Minecraft server implemented in PHP
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/
namespace HHVMCraft\Core\Networking\Packets;

class EntityRelativeMovePacket {
	const id = 0x1F;

	public $eid; // Entity ID
	public $dX; // X axis relative movement as absolute int
	public $dY; // Y axis relative movement as absolute int
	public $dZ; // Z axis relative movement as absolute int

	public function __construct($eid, $dX, $dY, $dZ) {
		$this->eid = $eid;
		$this->dX = $dX;
		$this->dY = $dY;
		$this->dZ = $dZ;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt($this->eid) .
			$StreamWrapper->writeInt8($this->dX) .
			$StreamWrapper->writeInt8($this->dY) .
			$StreamWrapper->writeInt8($this->dZ);

		return $StreamWrapper->writePacket($str);
	}
}
