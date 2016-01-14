<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

class RespawnPacket {
	const id = 0x09;
	public $world;

	public function __construct($world=0x00) {
		$this->world = $world;
	}

	public function readPacket($StreamWrapper) {
		$this->world = $StreamWrapper->readInt8();
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt8($this->world);

		return $StreamWrapper->writePacket($str);
	}
}
