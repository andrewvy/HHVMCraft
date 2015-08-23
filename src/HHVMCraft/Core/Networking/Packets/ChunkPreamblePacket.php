<?php
/**
* This file is part of HHVMCraft - a Minecraft server implemented in PHP
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/
namespace HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Helpers\Hex;

class ChunkPreamblePacket {
	const id = 0x32;
	public $x;
	public $z;
	public $load;

	public function __construct($x, $z, $load = true) {
		$this->x = $x;
		$this->z = $z;
		$this->load = $load;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id) .
		$StreamWrapper->writeInt($this->x) .
		$StreamWrapper->writeInt($this->z) .
		$StreamWrapper->writeUInt8($this->load);

		return $StreamWrapper->writePacket($str);
	}
}
