<?php

use HHVMCraft\Core\TerrainGen\FlatlandGenerator;
use HHVMCraft\Core\World\Chunk;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Coordinates2D;

class FlatlandGeneratorTest extends PHPUnit_Framework_TestCase {
	public function testCanGenerateLayers() {
		$chunk1pos = new Coordinates3D(0,0);
		$generator = new FlatlandGenerator();

		$chunk = $generator->generateChunk($chunk1pos);

		$c = new Coordinates3D(0,20,0);
		$blockid = $chunk->getBlockID($c);
		$this->assertEquals($blockid, 0x00, "Expects block to be air at y-level 20");

		$c = new Coordinates3D(0,0,0);
		$blockid = $chunk->getBlockID($c);
		$this->assertEquals($blockid, 0x03, "Expects block to be dirt at y-level 0");


		$c = new Coordinates3D(0,9,0);
		$blockid = $chunk->getBlockID($c);
		$this->assertEquals($blockid, 0x02, "Expects block to be grass at y-level 9");
	}
}

