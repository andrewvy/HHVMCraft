<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class SoundEffectPacket {
	const id = 0x3D;
	public $effectId;
	public $x;
	public $y;
	public $z;
	public $soundData;

	public function __construct($effectId, $x, $y, $z, $soundData) {
		$this->effectId = $effectId;
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->soundData = $soundData;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt($this->effectId) .
			$StreamWrapper->writeInt($this->x) .
			$StreamWrapper->writeInt8($this->y) .
			$StreamWrapper->writeInt($this->z) .
			$StreamWrapper->writeInt($this->soundData);

		return $StreamWrapper->writePacket($str);
	}
}
