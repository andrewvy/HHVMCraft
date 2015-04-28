<?php
/**
 * FlatlandGenerator is part of HHVMCraft - a Minecraft server implemented in PHP
 * - Just generates chunks that are exactly the same.
 * - Dirt from layers 1-8, and grass on layer 9.
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\TerrainGen;

use HHVMCraft\API\Coordinates3D;
use HHVMCraft\Core\World\Chunk;

class FlatlandGenerator {
  const LevelType = "FLAT";
  public $spawnpoint;
  public $layers = [];

  public function __construct() {
    $this->spawnpoint = new Coordinates3D(0, 10, 0);
  }

  public function generateChunk($Coordinates2DPos) {
    $newC = new Chunk($Coordinates2DPos);
    $y = 0;
    // Flatland, dirt from layer 1 - 8, grass on layer 9.
    while ($y < 10) {
      for ($x = 0; $x < 16; $x++) {
        for ($z = 0; $z < 16; $z++) {
          if ($y < 9) {
            $newC->setBlockID(new Coordinates3D($x, $y, $z), 0x03);
          }
          else {
            $newC->setBlockID(new Coordinates3D($x, $y, $z), 0x02);
          }
        }
      }

      $y++;
    }

    return $newC;
  }
}
