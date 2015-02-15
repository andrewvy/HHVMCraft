<?php


namespace HHVMCraft\Core\World;

class World {
	public $WorldTime;

	public $Regions = [];
	public $BlockProvider;
	public $ChunkProvider;

	public function __construct($name, $BlockProvider, $ChunkProvider) {
		$this->WorldTime = new DateTime();
		$this->BlockProvider = $BlockProvider;
		$this->ChunkProvider = $ChunkProvider;
	}

	public function getTime() {
		return ( ( (int) $this->WorldTime->diff(new Datetime())->format("%s") * 20) % 24000 );	
	}
}
