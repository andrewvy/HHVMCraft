<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
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
		$this->username = $Client->username;
	}

	public function spawnPacket() {
		return new SpawnPlayerPacket($this->entityId,
			$this->Position->x,
			$this->Position->y,
			$this->Position->z,
			((($this->Yaw % 360) / 360) * 256),
			((($this->Pitch % 360) / 360) * 256),
			0);
	}
}
