<?php


namespace HHVMCraft\Core\World;

class World {
	public $worldname;
	public $WorldTime;

	public $Regions = [];
	public $BlockProvider;
	public $ChunkProvider;

	public function __construct($worldname, $BlockProvider) {
		$this->worldname = $worldname;
		$this->WorldTime = new DateTime();
		$this->BlockProvider = $BlockProvider;
		$this->ChunkProvider = new FlatlandGenerator();
	}

	public function getTime() {
		return ( ( (int) $this->WorldTime->diff(new Datetime())->format("%s") * 20) % 24000 );	
	}

	public function getChunk($Coordinates2D) {
		
	}
}
