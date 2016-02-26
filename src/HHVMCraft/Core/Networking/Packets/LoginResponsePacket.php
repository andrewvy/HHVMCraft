<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class LoginResponsePacket {
	const id = 0x01;
	public $Dimension;
	public $EntityID;
	public $Seed;

	public function __construct($entityID, $seed, $dimension) {
		$this->EntityID = $entityID;
		$this->Seed = $seed;
		$this->Dimension = $dimension;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->EntityID) .
		$StreamWrapper->writeInt16(0) .
		$StreamWrapper->writeLong($this->Seed) .
		$StreamWrapper->writeInt8($this->Dimension);

		return $StreamWrapper->writePacket($p);
	}
}
