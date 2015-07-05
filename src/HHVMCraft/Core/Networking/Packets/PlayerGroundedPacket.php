<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class PlayerGroundedPacket {
	const id = "0a";
	public $onGround;

	public function readPacket($StreamWrapper) {
		$this->onGround = $StreamWrapper->readBool();
	}
}
