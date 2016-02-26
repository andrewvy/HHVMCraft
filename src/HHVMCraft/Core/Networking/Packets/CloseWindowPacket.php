<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class CloseWindowPacket {
	const id = 0x65;
	public $windowId;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->windowId = $StreamWrapper->readInt8();
	}
}
