<?php

// A region is a 32x32 chunk area which can be partially loaded in memory.
// In this implementation, we'll just store the whole region in memory for now.

namespace HHVMCraft\Core\World;

require "HHVMCraft.API/Coordinates2D.php";

use HHVMCraft\API\Coordinates2D;

class Region {
	const Width = 32;
	const Depth = 32;

	public $x;
	public $z;
	public $World;
	public $Chunks = [];

	public function __construct($Coordinates2D, $World) {
		$this->x = $Coordinates2D->x;
		$this->z = $Coordinates2D->z;
		$this->World =& $World;
	}

	public function getChunk($Coordinates2D) {
		// Get chunk from memory/disk, or generate a chunk if not loaded.
	}

	public function generateChunk($Coordinates2D) {
		// Generates chunk from chunk provider	
		$Global2DCoordinates = new Coordinates2D(($this->x * $this::Width) + $Coordinates2D->x, ($this->z * $this::Depth) + $Coordinates2D->z);
		$Chunk = $this->World->generateChunk($Global2DCoordinates);
		$Chunk->isModified = true;
		$Chunk->setCoordinates($Global2DCoordinates);
		$Chunks[$Global2DCoordinates] = $Chunk;
	}

	public function setChunk($Coordinates2D) {

	}
}
