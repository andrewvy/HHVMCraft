<?php

namespace HHVMCraft\Core\Networking;
use HHVMCraft\Core\Networking\Connection;

class Client {
	public $Connection;
	public $Player;

	public function __construct($socket, $server) {
		$this->$Connection = new Connection($socket, $server);
	}
}
