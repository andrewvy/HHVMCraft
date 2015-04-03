<?php

namespace HHVMCraft\Core\Entities;

require "vendor/autoload.php";
require "HHVMCraft.API/Vector3.php";
require "HHVMCraft.API/Coordinates3D.php";

use HHVMCraft\API\Vec3;
use HHVMCraft\API\Coordinates3D;
use Evenement\EventEmitter;

class Entity {
	public $enablePropertyChange = true;
	public $entityId = -1;
	public $spawnTime;

	public $Position;
	public $Velocity;
	public $Yaw;
	public $Pitch;
	public $EntityFlags;
	public $Despawned;

	public $Event;

	public function __construct($Event) {
		$this->spawnTime = new \DateTime();
		$this->Velocity = new Vec3(0,0,0);
		$this->Position = new Coordinates3D(0,0,0);
		$this->OldPosition = new Coordinates3D(0,0,0);
		$this->Event = $Event;
	}


	public function setPosition($x=0, $y=0, $z=0) {
		$this->Position->x = $x;
		$this->Position->y = $y;
		$this->Position->z = $z;

		$this->propertyChanged("Position");
	}

	public function setVelocity($x=0, $y=0, $z=0) {
		$this->Velocity->x = $x;
		$this->Velocity->y = $y;
		$this->Velocity->z = $z;

		$this->propertyChanged("Velocity");
	}

	public function setYaw($Yaw) {
		$this->Yaw = $Yaw;

		$this->propertyChanged("Yaw");
	}

	public function setPitch($Pitch) {
		$this->Pitch = $Pitch;

		$this ->propertyChanged("Pitch");
	}

	public function setEntityFlags($value) {
		$this->EntityFlags = $value;

		$this->propertyChanged("Metadata");
	}

	public function metadata() {
		// Metadata Dictionary???
	}

	public function update($EntityManager) {
		if ($this->Position->Y < -50) {
			$EntityManager->despawnEntity($this);
		}
	}

	public function propertyChanged($propertyName) {
		if ($this->enablePropertyChange == true) {
			$this->Event->emit("PropertyChanged", array($this, $propertyName) );
		}
	}



}
