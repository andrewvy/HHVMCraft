<?php

namespace HHVMCraft\Core\World;

require "HHVMCraft.Core/TerrainGen/FlatlandGenerator.php";
require "HHVMCraft.API/Coordinates2D.php";

use HHVMCraft\Core\TerrainGen\FlatlandGenerator;
use HHVMCraft\API\Coordinates2D;

class World {
	public $worldname;
	public $WorldTime = 4000;

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
		if ($this->WorldTime == 24000) {
			$this->WorldTime = 0;
		}
		else {
			$this->WorldTime += 20;
		}
	}

	public function getChunk($Coordinates2D) {

	}

	// For quick purposes, let's just generate a 0,0 chunk.
	public function getFakeChunk() {
		$Coordinates2D = new Coordinates2D(0,0);
		return $this->ChunkProvider->generateChunk($Coordinates2D);
	}

	public function generateChunk($Coordinates2D) {
		return $this->ChunkProvider->generateChunk($Coordinates2D);
	}

	public function setBlockId($Coordinates3D, $id) {

	}

}
