<?php

namespace HHVMCraft\Core\Entities;

use HHVMCraft\Core\Networking\Packets\SpawnPlayerPacket;

class PlayerEntity extends LivingEntity {
	const MaxHealth = 20;
	const Width = 0.6;
	const Height = 1.62;
	const Depth = 0.6;

	public $username;
	public $food;
	public $isCrouching = false;
	public $isSprinting = false;

	public function __construct($Client, $Event) {
		parent::__construct($Event);

		$this->username = $Client->username;
	}

	public function spawnPacket() {
		return new SpawnPlayerPacket(
			$this->entityId,
			$this->username,
			(int) $this->Position->x,
			(int) $this->Position->y,
			(int) $this->Position->z,
			((($this->Yaw % 360) / 360) * 256),
			((($this->Pitch % 360) / 360) * 256),
			0);
	}
}
