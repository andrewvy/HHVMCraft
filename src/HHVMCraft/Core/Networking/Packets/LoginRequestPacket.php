<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class LoginRequestPacket {
	const id = "01";
	public $protocolVersion;
	public $username;

	public function readPacket($StreamWrapper) {
		$this->protocolVersion = hexdec(bin2hex($StreamWrapper->readInt()));
		$this->username = $StreamWrapper->readString16();

		// These bytes are not used..

		$StreamWrapper->readLong();
		$StreamWrapper->readUInt8();
	}
}
