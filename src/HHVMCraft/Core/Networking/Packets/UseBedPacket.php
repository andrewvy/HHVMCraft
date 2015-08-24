<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

class UseBedPacket {
	const id = 0x11;

	public $eid;
	public $in_bed;
	public $x;
	public $y;
	public $z;

	public function readPacket($StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();
		$this->in_bed = $StreamWrapper->readUInt8();
		$this->x = $StreamWrapper->readInt();
		$this->y = $StreamWrapper->readUInt8();
		$this->z = $StreamWrapper->readInt();
	}

}
