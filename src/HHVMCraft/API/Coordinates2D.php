<?php

namespace HHVMCraft\API;

class Coordinates2D {
	public $x;
	public $z;

	public $Zero;
	public $Forward;
	public $Backward;
	public $Left;
	public $Right;

	public function __construct($x=0, $z=0) {
		$this->x = $x;
		$this->z = $z;
	}

	public function toString() {
		return sprintf('<%d, %d>', $this->x, $this->z);
	}

	public function distanceTo($Coordinates2D)  {
		return sqrt( pow($Coordinates2D->x - $this->x, 2) + pow($Coordinates2D->z - $this->z, 2));
	}

	public function distance() {
		return $this->distanceTo($this->Zero);
	}

	public function equals($Coordinates2D) {
		if ($this->x == $Coordinates2D->x && $this->z == $Coordinates2D->z) {
			return true;
		} else {
			return false;
		}
	}

	public static function minimum($Coordinates2D1, $Coordinates2D2) {
		return new self(
			min($Coordinates2D1->x, $Coordinates2D2->x),
			min($Coordinates2D1->z, $Coordinates2D2->z)
		);
	}

	public static function maximum($Coordinates2D1, $Coordinates2D2) {
		return new self(
			max($Coordinates2D1->x, $Coordinates2D2->x),
			max($Coordinates2D1->z, $Coordinates2D2->z)
		);
	}

	public static function Zero() {
		return new self(0, 0);
	}

	public static function Forward() {
		return new self(0, 1);
	}

	public static function Backward() {
		return new self(0, -1);
	}

	public static function Left() {
		return new self(-1, 0);
	}

	public static function Right() {
		return new self(1, 0);
	}

}
