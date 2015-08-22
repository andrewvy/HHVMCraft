<?php

use HHVMCraft\Core\World\Chunk;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Coordinates2D;

class WorldTest extends PHPUnit_Framework_TestCase {
	public function testChunkGeneration() {
		$chunkCoordinates = new Coordinates2D(0,0);
		$blockCoordinates = new Coordinates3D(10,10,10);
		$chunk = new Chunk($chunkCoordinates);

		$this->assertEquals($chunk->getBlockID($blockCoordinates), 0x00, "Expects block to be air in the chunk");
	}
}

