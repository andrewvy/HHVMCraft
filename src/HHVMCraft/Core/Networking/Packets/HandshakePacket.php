<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class HandshakePacket {
	const id = "02";
	public $username;

	public function __construct($username="") {
		$this->username = $username;
	}

	public function readPacket($StreamWrapper) {
		$this->username = $StreamWrapper->readString16();
	}

	public function writePacket($stream) {

	}

}
