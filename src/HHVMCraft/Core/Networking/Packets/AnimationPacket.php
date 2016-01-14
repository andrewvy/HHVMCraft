<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

class AnimationPacket {
	const id = 0x12;

	public $eid;
	public $animate;

	public function readPacket($StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();
		$this->animate = $StreamWrapper->readInt8();
	}

}
