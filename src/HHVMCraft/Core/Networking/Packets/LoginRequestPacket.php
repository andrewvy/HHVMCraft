<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class LoginRequestPacket {
	const id = 0x01;
	public $protocolVersion;
	public $username;

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->protocolVersion = $StreamWrapper->readInt();
		$this->username = $StreamWrapper->readString16();

		// These bytes are not used..

		$StreamWrapper->readLong();
		$StreamWrapper->readInt8();
	}
}
