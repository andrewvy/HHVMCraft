<?php

require "HHVMCraft.Core/World/Chunk.php";
require "HHVMCraft.API/Coordinates3D.php";
require "HHVMCraft.API/Coordinates2D.php";

use HHVMCraft\Core\World\Chunk;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\API\Coordinates2D;

error_reporting(E_ERROR);

$chunkCoordinates = new Coordinates2D(0,0);
$blockCoordinates = new Coordinates3D(10,10,10);

$chunk = new Chunk($chunkCoordinates);

$blockID = 0x01;

if ($chunk->getBlockID($blockCoordinates) == 0x00) {
	echo "Got air. \n";
};

$chunk->setBlockID($blockCoordinates, 15);

echo $chunk->getBlockID($blockCoordinates)."\n";
