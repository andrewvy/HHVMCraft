<?php

namespace HHVMCraft\API;

class Vec3 {
	public $x;
	public $y;
	public $z;

	public function __construct($x = 0, $y = 0, $z = 0) {
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}
}
