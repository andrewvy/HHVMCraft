<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\World;

use HHVMCraft\API\Coordinates2D;
use HHVMCraft\API\Coordinates3D;
use HHVMCraft\Core\TerrainGen\FlatlandGenerator;

class World {
	public $worldname;
	public $WorldTime = 4020;

	public $Chunks = array();
	public $Regions = [];
	public $BlockProvider;
	public $ChunkProvider;

	public function __construct($worldname, $BlockProvider) {
		$this->worldname = $worldname;
		$this->BlockProvider = $BlockProvider;
		$this->ChunkProvider = new FlatlandGenerator();
	}

	public function getTime() {
		// World Time in Minecraft
		// 20 server ticks per second
		// 24000 ticks per day = 20 minutes a day
		// 0 is sunrise, 6000 is noon, 12000 is sunset, 18000 is midnight
		return $this->WorldTime;
	}

	public function updateTime() {
		// Every second, increase worldtime by 20 ticks.
//		if ($this->WorldTime == 24000) {
//			$this->WorldTime = 0;
//		} else {
//			$this->WorldTime += 20;
//		}
	}

	public function getChunk($Coordinates2D) {
		if (array_key_exists($Coordinates2D->toString(), $this->Chunks)) {
			return $this->Chunks[$Coordinates2D->toString()];
		} else {
			return null;
		}
	}

	public function setChunk($Coordinates2D, $Chunk) {
		$this->Chunks[$Coordinates2D->toString()] = $Chunk;

		return $Chunk;
	}

	// For quick purposes, let's just generate a 0,0 chunk.
	public function getFakeChunk() {
		$Coordinates2D = new Coordinates2D(0, 0);

		return $this->ChunkProvider->generateChunk($Coordinates2D);
	}

	public function generateChunk($Coordinates2D) {
		$chunk = $this->getChunk($Coordinates2D);

		if ($chunk) {
			return $chunk;
		} else {
			$new_chunk = $this->ChunkProvider->generateChunk($Coordinates2D);
			return $this->setChunk($Coordinates2D, $new_chunk);
		}
	}

	public function setBlockId($Coordinates3D, $id) {
		$chunkX = $Coordinates3D->x >> 4;
		$chunkZ = $Coordinates3D->z >> 4;

		$normalizedBlockCoordinates = new Coordinates3D($Coordinates3D->x % 16, $Coordinates3D->y % 128, $Coordinates3D->z % 16);
		$coordinates = new Coordinates2D($chunkX, $chunkZ);

		$chunk = $this->generateChunk($coordinates);
		$chunk->setBlockID($normalizedBlockCoordinates, $id);
	}

}
