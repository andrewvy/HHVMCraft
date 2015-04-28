<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

use HHVMCraft\Core\Helpers\Hex;

class ChunkDataPacket {
  const id = "33";

  public $x;
  public $y;
  public $z;

  public $Width;
  public $Height;
  public $Depth;
  public $BlockData;

  public function __construct($x, $y, $z, $Width, $Height, $Depth, $BlockData) {
    $this->x = $x;
    $this->y = $y;
    $this->z = $y;
    $this->Width = $Width - 1;
    $this->Height = $Height - 1;
    $this->Depth = $Depth - 1;
    $this->BlockData = $BlockData;
  }

  public function writePacket($StreamWrapper) {
    $str = $StreamWrapper->writeUInt8(self::id) .
      $StreamWrapper->writeInt($this->x * $this->Width) .
      $StreamWrapper->writeUInt16(0) .
      $StreamWrapper->writeInt($this->z * $this->Depth) .
      $StreamWrapper->writeUInt8("09") .
      $StreamWrapper->writeUInt8("7F") .
      $StreamWrapper->writeUInt8("09") .
      $StreamWrapper->writeInt(strlen($this->BlockData)) .
      $this->BlockData;

    Hex::dump($str);

    return $StreamWrapper->writePacket($str);
  }
}
