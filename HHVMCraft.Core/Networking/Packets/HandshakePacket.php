<?php

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
