<?php

namespace HHVMCraft\Core\Networking;

require 'Connection.php';

class Client {
	public $Connection;
	public $Player;

	public function __construct($socket, $server) {
		$this->$Connection = new \HHVMCraft\Core\Networking\Connection($socket, $server);
	}
}
