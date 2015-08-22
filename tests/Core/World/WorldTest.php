<?php

use HHVMCraft\Core\World\World;
use HHVMCraft\API\BlockProvider;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Coordinates2D;

class WorldTest extends PHPUnit_Framework_TestCase {
	public function testWorldGeneration() {
		$chunkCoordinates = new Coordinates2D(0,0);
		$blockCoordinates = new Coordinates3D(0,20,0);

		$BlockProvider = new BlockProvider();

		$world = new World("testworld", $BlockProvider);

		$this->assertEquals($world->worldname, "testworld", "Expects world name to be testworld");

		$chunk = $world->generateChunk($chunkCoordinates);

		$this->assertEquals($chunk->getBlockID($blockCoordinates), 0x00, "Expects block to be air in the chunk");
	}
}

