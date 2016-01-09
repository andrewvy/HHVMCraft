<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Helpers\Hex;

class ChunkDataPacket {
	const id = 0x33;

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
		$this->Width = $Width - 1;
		$this->Height = $Height - 1;
		$this->Depth = $Depth - 1;
		$this->BlockData = $BlockData;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id) .
		$StreamWrapper->writeInt(0) .
		$StreamWrapper->writeUInt16(0) .
		$StreamWrapper->writeInt(0) .
		$StreamWrapper->writeUInt8(15) .
		$StreamWrapper->writeUInt8(127) .
		$StreamWrapper->writeUInt8(15) .
		$StreamWrapper->writeInt(strlen($this->BlockData)) .
		$this->BlockData;

		return $StreamWrapper->writePacket($str);
	}
}
