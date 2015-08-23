<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class PlayerPositionPacket {
	const id = 0x0B;

	public $x;
	public $y;
	public $stance;
	public $z;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->x = floatval($StreamWrapper->readDouble());
		$this->y = floatval($StreamWrapper->readDouble());
		$this->stance = floatval($StreamWrapper->readDouble());
		$this->z = floatval($StreamWrapper->readDouble());
		$this->onGround = $StreamWrapper->readBool();
	}
}
