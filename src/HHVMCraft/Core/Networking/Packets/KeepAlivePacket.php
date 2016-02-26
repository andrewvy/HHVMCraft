<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class KeepAlivePacket {
	const id = 0x00;

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id);
		return $StreamWrapper->writePacket($str);
	}

	public function readPacket(StreamWrapper $StreamWrapper) {
		$StreamWrapper->readInt8();
	}
}
