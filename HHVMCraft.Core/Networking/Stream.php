<?php

namespace HHVMCraft\Core\Networking;

class Stream {
	public $physicalStream;

	public function __construct($stream) {
		$this->physicalStream = $stream;
	}
}
