<?php

namespace HHVMCraft\Core\Entities;

use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Vec3;

class Entity {
	public $enablePropertyChange = true;
	public $entityId = -1;
	public $spawnTime;
	public $uuid;

	public $Position;
	public $Velocity;
	public $Yaw;
	public $Pitch;
	public $EntityFlags;
	public $Despawned;

	public $Event;

	public function __construct($Event) {
		$this->uuid = uniqid("entity");
		$this->spawnTime = new \DateTime();
		$this->Velocity = new Vec3(0,0,0);
		$this->Position = new Coordinates3D(0,0,0);
		$this->OldPosition = new Coordinates3D(0,0,0);

		// This is the EventManager's event loop.
		// Used for propagating entity property updates to other clients.
		$this->Event = $Event;
	}

	public function setPosition($x=0, $y=0, $z=0) {
		$this->OldPosition->x = $this->Position->x;
		$this->OldPosition->y = $this->Position->y;
		$this->OldPosition->z = $this->Position->z;

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
		// TODO (vy): Metadata Dictionary???
	}

	public function update($EntityManager) {
		if ($this->Position->y < -50) {
			$EntityManager->despawnEntity($this);
		}
	}

	public function propertyChanged($propertyName) {
		if ($this->enablePropertyChange == true) {
			$this->Event->emit("PropertyChanged", array($this, $propertyName) );
		}
	}
}
