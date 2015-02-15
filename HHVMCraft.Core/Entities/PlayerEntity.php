<?php

namespace HHVMCraft\Core\Entities;

class PlayerEntity {
	const MaxHealth = 20;

	public $username;
	public $food;
	public $isCrouching = false;
	public $isSprinting = false;

	public function __construct($username) {
		$this->username = $username;
	}
}
