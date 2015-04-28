<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Physics;

class PhysicsEngine {
	public $World;
	public $BlockRepository;
	public $Entities = [];

	public function __construct($World, $BlockRepository) {
		$this->World = $World;
		$this->BlockRepository = $BlockRepository;
	}

	public function addEntity($Entity) {
	}

	public function removeEntity($Entity) {
	}

	public function update() {
	}

}
