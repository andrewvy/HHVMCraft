<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class KeepAlivePacket {
	const id = 0x00;

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id);
		return $StreamWrapper->writePacket($str);
	}

	public function readPacket($StreamWrapper) {
		$StreamWrapper->readInt8();
	}
}
