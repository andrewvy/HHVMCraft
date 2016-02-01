<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class SetSlotPacket {
	const id = 0x67;
	public $window_id;
	public $slot;
	public $item_id;
	public $item_count;
	public $item_uses;

	public function __construct($window_id, $slot, $item_id, $item_count, $item_uses) {
		$this->window_id = $window_id;
		$this->slot = $slot;
		$this->item_id = $item_id;
		$this->item_count = $item_count;
		$this->item_uses = $item_uses;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt8($this->window_id) .
			$StreamWrapper->writeInt16($this->slot) .
			$StreamWrapper->writeInt16($this->item_id) .
			$StreamWrapper->writeInt8($this->item_count) .
			$StreamWrapper->writeInt16($this->item_uses);

		return $StreamWrapper->writePacket($str);
	}
}
