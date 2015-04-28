<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class DestroyEntityPacket {
	const id = "1d";
	public $entityId;

	public function __construct($entityId) {
		$this->entityId = $entityId;
	}

	public function writePacket($StreamWrapper) {
		$str = $StreamWrapper->writeUInt8(self::id).
			$StreamWrapper->writeInt($this->entityId);

		return $StreamWrapper->writePacket($str);
	}

}
