<?php

namespace HHVMCraft\Core\Entities;

require "Entity.php";
use HHVMCraft\Core\Entities\Entity;

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
