<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class UseEntityPacket {
	const id = 0x07;

	public $user;
	public $target;
	public $leftclick;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->user = $StreamWrapper->readInt();
		$this->target = $StreamWrapper->readInt();
		$this->leftclick = $StreamWrapper->readInt8();
	}

}
