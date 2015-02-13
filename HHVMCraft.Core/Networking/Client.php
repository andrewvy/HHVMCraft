<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Networking/Stream.php";
require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\StreamWrapper;

class Client {
	public $server;
	public $connection;
	public $StreamWrapper;

	public $lastSuccessfulPacket;

	public function __construct(&$connection, $server) {
		$this->connection = &$connection;
		$this->StreamWrapper = new StreamWrapper(&$connection->stream);
		$this->server = $server;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$this->connection->on('data', function($data) {
			$this->stream->data($data);
			$this->server->handlePacket($data);
		});
	}
}
