<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
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

  public function __construct($x = 0, $y = 0, $z = 0) {
    $this->x = $x;
    $this->y = $y;
    $this->z = $z;
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

  public static function convert2Dto3D($Coordinates2D) {
    return new self($Coordinates2D->x, 0, $Coordinates2D->z);
  }

  public static function Vec3to3D($Vect3) {
    return new self($Vect3->x, $Vect3->y, $Vect3->z);
  }

  public static function Sizeto3D($Size) {
    return new self($Size->Width, $Size->Height, $Size->Depth);
  }

  public static function One() {
    return new self(1, 1, 1);
  }

  public static function Up() {
    return new self(0, 1, 0);
  }

  public static function Down() {
    return new self(0, -1, 0);
  }

  public static function Left() {
    return new self(-1, 0, 0);
  }

  public static function Right() {
    return new self(1, 0, 0);
  }

  public static function Backwards() {
    return new self(0, 0, -1);
  }

  public static function Forwards() {
    return new self(0, 0, 1);
  }

  public static function East() {
    return new self(1, 0, 0);
  }

  public static function West() {
    return new self(-1, 0, 0);
  }

  public static function North() {
    return new self(0, 0, -1);
  }

  public static function South() {
    return new self(0, 0, 1);
  }

  public static function OneX() {
    return new self(1, 0, 0);
  }

  public static function OneY() {
    return new self(0, 1, 0);
  }

  public static function OneZ() {
    return new self(0, 0, 1);
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

  public function distance() {
    return $this->distanceTo($this->Zero());
  }

  public function distanceTo($Coordinates3D) {
    return sqrt(pow($Coordinates3D->x - $this->x, 2) + pow($Coordinates3D->y - $this->y,
        2) + pow($Coordinates3D->z - $this->z, 2));
  }

  public static function Zero() {
    return new self(0, 0, 0);
  }

  public function equals($Coordinates3D) {
    if ($this->x == $Coordinates3D->x && $this->y == $Coordinates3D->y && $this->z == $Coordinates3D->z) {
      return true;
    }
    else {
      return false;
    }
  }

}
