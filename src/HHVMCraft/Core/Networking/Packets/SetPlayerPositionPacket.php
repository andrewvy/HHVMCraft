<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class SetPlayerPositionPacket {
	const id = "0b";
	public $x;
	public $y;
	public $z;
	public $stance;
	public $yaw;
	public $pitch;
	public $onGround;

	public function __construct($x, $y, $z, $stance, $yaw, $pitch, $onGround) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->stance = $stance;
		$this->yaw = $yaw;
		$this->pitch = $pitch;
		$this->onGround = $onGround;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeDouble($this->x).
			$StreamWrapper->writeDouble($this->stance).
			$StreamWrapper->writeDouble($this->y).
			$StreamWrapper->writeDouble($this->z).
			$StreamWrapper->writeInt($this->yaw).
			$StreamWrapper->writeInt($this->pitch).
			$StreamWrapper->writeBool($this->onGround);

		return $StreamWrapper->writePacket($str);
	}
}
