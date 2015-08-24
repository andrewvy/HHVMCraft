<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

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

	public function readPacket($StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();
		$this->item = $StreamWrapper->readUInt16();
		$this->itemcount = $StreamWrapper->readUInt8();
		$this->damage = $StreamWrapper->readUInt16();
		$this->x = $StreamWrapper->readInt();
		$this->y = $StreamWrapper->readInt();
		$this->z = $StreamWrapper->readInt();
		$this->rotation = $StreamWrapper->readUInt8();
		$this->pitch = $StreamWrapper->readUInt8();
		$this->roll = $StreamWrapper->readUInt8();
	}
}
