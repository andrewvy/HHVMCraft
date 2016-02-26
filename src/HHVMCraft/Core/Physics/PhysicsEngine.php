<?php

namespace HHVMCraft\Core\Physics;

class PhysicsEngine {
	public $World;
	public $BlockRepository;
	public $Entities = [];

	public function __construct($World, $BlockRepository) {
		$this->World = $World;
		$this->BlockRepository = $BlockRepository;
	}

	// TODO (vy): Methods for manipulating PhysicsEngine tracked entities

	public function addEntity($Entity) {
	}

	public function removeEntity($Entity) {
	}

	public function update() {
	}

}
