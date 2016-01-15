<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

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

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt8($this->windowId) .
			$StreamWrapper->writeInt8($this->inventoryType) .
			$StreamWrapper->writeString16($this->windowTitle) .
			$StreamWrapper->writeInt8($this->numberOfSlots);

		return $StreamWrapper->writePacket($str);
	}
}
