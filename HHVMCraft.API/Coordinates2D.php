<?php

namespace HHVMCraft\API;

class Coordinates2D {
	public $x;
	public $z;

	const $Zero = new self(0, 0);
	const $Forward = new self(0, 1);
	const $Backward = new self(0, -1);
	const $Left = new self(-1, 0);
	const $Right = new self(1,0);

	public function __construct($x, $z) {
		$this->x = $x;
		$this->z = $z;
	}

	public function toString() {
		return sprintf('<%d, %d>', $this->x, $this->z);
	}

	public function distanceTo($Coordinates2D)  {
		return sqrt( pow($Coordinates2D->x, 2) + pow($Coordinates2D->z, 2));
	}

	public function distance() {
		return $this->distanceTo(self::Zero);
	}

	public function equals($Coordinates2D) {
		if ($this->x == $Coordinates2D->x && $this->z == $Coordinates2D->z) {
			return true;
		} else {
			return false;
		}
	}

	public static min($Coordinates2D1, $Coordinates2D2) {
		return new self( min($Coordinates2D1->x, $Coordinates2D2->x),
			min($Coordinates2D1->z, $Coordinates2D2->z) );
	}

	public static max($Coordinates2D1, $Coordinates2D2) {
		return new self( max($Coordinates2D1->x, $Coordinates2D2->x),
			max($Coordinates2D1->z, $Coordinates2D2->z) );
	}

}
