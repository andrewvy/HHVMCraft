<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Packets;

class HandshakeResponsePacket {
  const id = "02";
  public $connectionHash;

  public function __construct($connectionHash = "") {
    $this->connectionHash = $connectionHash;
  }

  public function readPacket($StreamWrapper) {
  }

  public function writePacket($StreamWrapper) {
    $str = $StreamWrapper->writeUInt8(self::id) .
      $StreamWrapper->writeUInt16(strlen($this->connectionHash)) .
      $StreamWrapper->writeString16($this->connectionHash);

    return $StreamWrapper->writePacket($str);
  }
}
