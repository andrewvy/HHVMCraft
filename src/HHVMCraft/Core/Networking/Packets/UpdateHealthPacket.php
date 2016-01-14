<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class UpdateHealthPacket {
	const id = 0x08;
	public $health;

	public function __construct($health=0) {
		$this->health = $health;
	}

	public function writePacket($StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt16($this->health);

		return $StreamWrapper->writePacket($p);
	}
}
