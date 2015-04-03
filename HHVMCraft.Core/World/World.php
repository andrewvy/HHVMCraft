<?php

namespace HHVMCraft\Core\World;

require "HHVMCraft.Core/TerrainGen/FlatlandGenerator.php";
require "HHVMCraft.API/Coordinates2D.php";

use HHVMCraft\Core\TerrainGen\FlatlandGenerator;
use HHVMCraft\API\Coordinates2D;

class World {
	public $worldname;
	public $WorldTime;

	public $Regions = [];
	public $BlockProvider;
	public $ChunkProvider;

	public function __construct($worldname, $BlockProvider) {
		$this->worldname = $worldname;
		$this->WorldTime = new \DateTime();
		$this->BlockProvider = $BlockProvider;
		$this->ChunkProvider = new FlatlandGenerator();
	}

	public function getTime() {
		return ( ( (int) $this->WorldTime->diff(new \Datetime())->format("%s") * 20) % 24000 );
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
