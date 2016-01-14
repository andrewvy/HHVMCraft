<?php
/**
* This file is part of HHVMCraft - a Minecraft server implemented in PHP
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/
namespace HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Helpers\Hex;

class BlockChangePacket {
	const id = 0x35;
	public $x;
	public $y;
	public $z;
	public $blockId;
	public $blockMetadata;

	public function __construct($x, $y, $z, $blockId, $blockMetadata) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->blockId = $blockId;
		$this->blockMetadata = $blockMetadata;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->x) .
		$StreamWrapper->writeInt8($this->y) .
		$StreamWrapper->writeInt($this->z) .
		$StreamWrapper->writeInt8($this->blockId) .
		$StreamWrapper->writeInt8($this->blockMetadata);

		return $StreamWrapper->writePacket($str);
	}
}
