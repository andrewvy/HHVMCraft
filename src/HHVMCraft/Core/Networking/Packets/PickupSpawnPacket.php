<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PickupSpawnPacket {
	const id = 0x15;

	public $eid;
	public $item;
	public $itemcount;
	public $damage;
	public $x;
	public $y;
	public $z;
	public $rotation;
	public $pitch;
	public $roll;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();
		$this->item = $StreamWrapper->readInt16();
		$this->itemcount = $StreamWrapper->readInt8();
		$this->damage = $StreamWrapper->readInt16();
		$this->x = $StreamWrapper->readInt();
		$this->y = $StreamWrapper->readInt();
		$this->z = $StreamWrapper->readInt();
		$this->rotation = $StreamWrapper->readInt8();
		$this->pitch = $StreamWrapper->readInt8();
		$this->roll = $StreamWrapper->readInt8();
	}
}
