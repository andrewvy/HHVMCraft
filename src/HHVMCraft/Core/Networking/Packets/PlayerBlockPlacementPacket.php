<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class PlayerBlockPlacementPacket {
	const id = 0x0F;

	public $x;
	public $y;
	public $z;
	public $direction;
	public $blockid;
	public $amount;
	public $damage;

	public function readPacket($StreamWrapper) {
		$this->x = $StreamWrapper->readInt();
		$this->y = $StreamWrapper->readUInt8();
		$this->z = $StreamWrapper->readInt();
		$this->direction = $StreamWrapper->readUInt8();
		$this->blockid = $StreamWrapper->readUInt16();

		if ($this->blockid >= 0x00) {
			$this->amount = $StreamWrapper->readUInt8();
			$this->damage = $StreamWrapper->readUInt16();
		}
	}

}
