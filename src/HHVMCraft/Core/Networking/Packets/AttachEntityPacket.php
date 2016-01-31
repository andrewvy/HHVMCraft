<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class AttachEntityPacket {
	const id = 0x27;
	public $entity_id;
	public $vehicle_id;

	public function __construct($entity_id, $vehicle_id) {
		$this->entity_id = $entity_id;
		$this->vehicle_id = $vehicle_id;
	}

	public function writePacket($StreamWrapper) {
		$p = $StreamWrapper->writeInt8(self::id) .
		$StreamWrapper->writeInt($this->entity_id) .
		$StreamWrapper->writeInt($this->vehicle_id);

		return $StreamWrapper->writePacket($p);
	}
}
