<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PlayerDiggingPacket {
	const id = 0x0E;

	// Status can be one of four values:
	// 0: Started digging
	// 2: Finished digging
	// 4: Drop item

	public $status;
	public $x;
	public $y;
	public $z;
	public $face;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->status = $StreamWrapper->readInt8();
		$this->x = $StreamWrapper->readInt();
		$this->y = $StreamWrapper->readInt8();
		$this->z = $StreamWrapper->readInt();
		$this->face = $StreamWrapper->readInt8();
	}
}
