<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Entities;

class LivingEntity extends Entity {
	const sendMetaDataToClients = true;
	public $air;
	public $health;
	public $headYaw;

	public function __construct($Event) {
		parent::__construct($Event);
	}

	public function setAir($value) {
		$this->air = $value;

		$this->propertyChanged("Air");
	}

	public function setHealth($value) {
		$this->health = $value;

		$this->propertyChanged("Health");
	}

	public function setHeadYaw($value) {
		$this->headYaw = $value;

		$this->propertyChanged("HeadYaw");
	}
}
