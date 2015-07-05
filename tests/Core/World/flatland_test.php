<?php

require "../../../HHVMCraft.Core/World/Chunk.php";
require "../../../HHVMCraft.API/Coordinates3D.php";
require "../../../HHVMCraft.API/Coordinates2D.php";
require "../../../../HHVMCraft.Core/TerrainGen/FlatlandGenerator.php";

use HHVMCraft\Core\TerrainGen\FlatlandGenerator;
use HHVMCraft\Core\World\Chunk;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Coordinates2D;

error_reporting(E_ERROR);

$chunk1pos = new Coordinates3D(0,0);

$generator = new FlatlandGenerator();

$chunk = $generator->generateChunk($chunk1pos);

// Generate flatland chunk, find block ID at X: 0, Z: 0. Check first 20 layers.

for ($y=0;$y<20;$y++) {
	$c = new Coordinates3D(0,$y,0);
	echo " >> Block ID at layer: ".$y." - ".$chunk->getBlockID($c)."\n";
}
