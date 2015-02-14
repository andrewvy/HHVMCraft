<?php

namespace HHVMCraft\Core\Networking\Packets;
require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
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
