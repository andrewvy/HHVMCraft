<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class UpdateSignPacket {
	const id = 0x82;
	public $x;
	public $y;
	public $z;
	public $text1;
	public $text2;
	public $text3;
	public $text4;

	public function __construct($x, $y, $z, $text1, $text2, $text3, $text4) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->text1 = $text1;
		$this->text2 = $text2;
		$this->text3 = $text3;
		$this->text4 = $text4;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt($this->x) .
			$StreamWrapper->writeInt16($this->y) .
			$StreamWrapper->writeInt($this->z) .
			$StreamWrapper->writeInt16($this->text1) .
			$StreamWrapper->writeString16($this->text1) .
			$StreamWrapper->writeInt16($this->text2) .
			$StreamWrapper->writeString16($this->text2) .
			$StreamWrapper->writeInt16($this->text3) .
			$StreamWrapper->writeString16($this->text3) .
			$StreamWrapper->writeInt16($this->text4) .
			$StreamWrapper->writeString16($this->text4);

		return $StreamWrapper->writePacket($str);
	}
}
