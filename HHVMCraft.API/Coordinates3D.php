<?php

namespace HHVMCraft\API;

class Coordinates3D {
	public $x;
	public $y;
	public $z;

	public $Zero;
	public $One;

	public $Up;
	public $Down;
	public $Left;
	public $Right;
	public $Backwards;
	public $Forwards;

	public $East;
	public $West;
	public $North;
	public $South;

	public $OneX;
	public $OneY;
	public $OneZ;

	public function __construct($x=0, $y=0, $z=0) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;	

/*
		$this->Zero = new self(0,0,0);
		$this->One = new self(1,1,1);

		$this->Up = new self(0,1,0);
		$this->Down = new self(0,-1,0);
		$this->Left = new self(-1,0,0);
		$this->Right = new self(1,0,0);
		$this->Backwards = new self(0,0,-1);
		$this->Forwards = new self(0,0,1);

		$this->East = new self(1,0,0);
		$this->West = new self(-1,0,0);
		$this->North = new self(0,0,-1);
		$this->South = new self(0,0,1);

		$this->OneX = new self(1,0,0);
		$this->OneY = new self(0,1,0);
		$this->OneZ = new self(0,0,1);	
 */

	}

	public function toString() {
		return sprintf('<%d, %d, %d>', $this->x, $this->y, $this->z);
	}

	public function clamp($val) {
		if (abs($this->x) > $val) {
			$this->x = $val * ($this->x ? -1 : 1);	
		}
		if (abs($this->y) > $val) {
			$this->y = $val * ($this->y ? -1 : 1);	
		}
		if (abs($this->x) > $val) {
			$this->z = $val * ($this->z ? -1 : 1);	
		}
	}

	public function distanceTo($Coordinates3D) {
		return sqrt( pow($Coordinates3D->x - $this->x, 2) + pow($Coordinates3D->y - $this->y, 2) + pow($Coordinates3D->z - $this->z, 2) );
	}

	public function distance() {
		return $this->distanceTo($this->Zero);	
	}

	public static function minimum($Coordinates3D1, $Coordinates3D2) {
		return new self(
			min($Coordinates3D1->x, $Coordinates3D2->x),
			min($Coordinates3D1->y, $Coordinates3D2->y),
			min($Coordinates3D1->z, $Coordinates3D2->z)
		);
	}

	public static function maximum($Coordinates3D1, $Coordinates3D2) {
		return new self(
			max($Coordinates3D1->x, $Coordinates3D2->x),
			max($Coordinates3D1->y, $Coordinates3D2->y),
			max($Coordinates3D1->z, $Coordinates3D2->z)
		);
	}
/*
	public function 2Dto3D($Coordinates2D) {
		return new self($Coordinates2D->x, 0, $Coordinates2D->z);
	}

	public function Vec3to3D($Vect3) {
		return new self($Vect3->x, $Vect3->y, $Vect3->z);
	}

	public function Sizeto3D($Size) {
		return new self($Size->Width, $Size->Height, $Size->Depth);
	}
 */
	public function equals($Coordinates3D) {
		if ($this->x == $Coordinates3D->x && $this->y == $Coordinates3D->y && $this->z == $Coordinates3D->z) {
			return true;
		} else {
			return false;
		}
	}

}
