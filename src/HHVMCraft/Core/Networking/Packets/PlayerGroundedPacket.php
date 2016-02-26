<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class PlayerGroundedPacket {
	const id = 0x0A;
	public $onGround;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->onGround = $StreamWrapper->readInt8();
	}
}
