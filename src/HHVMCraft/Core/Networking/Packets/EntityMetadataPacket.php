<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class EntityMetadataPacket {
	const id = 0x28;

	public $eid;
	public $metadata;

	public function readPacket($StreamWrapper) {
		$this->eid = $StreamWrapper->readInt();

		// TODO (vy): Implement metadata parsing..
	}
}
