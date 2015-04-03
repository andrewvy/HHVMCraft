<?php

namespace HHVMCraft\Core\Networking\Packets;

class KeepAlivePacket {
	const id = "00";

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id);

		return $StreamWrapper->writePacket($str);
	}

	public function readPacket($StreamWrapper) {
		$StreamWrapper->readUInt16();
	}

}
