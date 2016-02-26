<?php

namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Networking\StreamWrapper;

class EntityEquipmentPacket {
	const id = 0x05;

	public $eid;
	public $slot;
	public $itemid;
	public $damage;

	public function __construct($eid, $slot, $itemid, $damage) {
		$this->eid = $eid;
		$this->slot = $slot;
		$this->itemid = $itemid;
		$this->damage = $damage;
	}

	public function writePacket(StreamWrapper $StreamWrapper) {
		$str = $StreamWrapper->writeInt8(self::id) .
			$StreamWrapper->writeInt($this->eid) .
			$StreamWrapper->writeInt16($this->slot) .
			$StreamWrapper->writeInt16($this->itemid) .
			$StreamWrapper->writeInt16($this->damage);

		return $StreamWrapper->writePacket($str);
	}
}
