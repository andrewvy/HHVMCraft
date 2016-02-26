<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class OpenWindowPacket {
	const id = 0x64;
	public $windowId;
	public $inventoryType;
	public $windowTitle;
	public $numberOfSlots;

	public function __construct($windowId, $inventoryType, $windowTitle, $numberOfSlots) {
		$this->windowId = $windowId;
		$this->inventoryType = $inventoryType;
		$this->windowTitle = $windowTitle;
		$this->numberOfSlots = $numberOfSlots;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt8($this->windowId) .
			$StreamWrapper->writeInt8($this->inventoryType) .
			$StreamWrapper->writeString16($this->windowTitle) .
			$StreamWrapper->writeInt8($this->numberOfSlots);

		return $StreamWrapper->writePacket($str);
	}
}
