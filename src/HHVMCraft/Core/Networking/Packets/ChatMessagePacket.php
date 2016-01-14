<?php
/**
* This file is part of HHVMCraft - a Minecraft server implemented in PHP
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/
namespace HHVMCraft\Core\Networking\Packets;

class ChatMessagePacket {
	const id = 0x03;
	public $message;

	public function __construct($message="") {
		$this->message = $message;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt16(strlen($this->message)) .
		$StreamWrapper->writeString16($this->message);

		return $StreamWrapper->writePacket($str);
	}

	public function readPacket($StreamWrapper) {
		$this->message = $StreamWrapper->readString16();
	}
}
