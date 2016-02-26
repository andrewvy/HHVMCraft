<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class CollectItemPacket {
	const id = 0x16;

	public $collected_eid;
	public $collector_eid;

	public function __construct($collected_eid, $collector_eid) {
		$this->collected_eid = $collected_eid;
		$this->collector_eid = $collector_eid;
	}

	public function readPacket(StreamWrapper $StreamWrapper) {
		$this->collected_eid = $StreamWrapper->readInt();
		$this->collector_eid = $StreamWrapper->readInt();
	}

	public function writePacket(StreamWrapper $StreamWrapper) {

	}
}
