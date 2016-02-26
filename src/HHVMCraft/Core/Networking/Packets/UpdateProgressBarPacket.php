<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class UpdateProgressBarPacket {
	const id = 0x69;
	public $window_id;
	public $progress_bar;
	public $progress_value;

	public function __construct($window_id, $progress_bar, $progress_value) {
		$this->window_id = $window_id;
		$this->progress_bar = $progress_bar;
		$this->progress_value = $progress_value;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt8($this->window_id) .
		$StreamWrapper->writeInt16($this->progress_bar) .
		$StreamWrapper->writeInt16($this->progress_value);

		return $StreamWrapper->writePacket($p);
	}
}
