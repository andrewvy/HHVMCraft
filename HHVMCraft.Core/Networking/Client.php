<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Networking/Stream.php";
require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\Stream;

class Client {
	public $server;
	public $connection;
	public $stream;

	public $lastSuccessfulPacket;

	public function __construct(&$connection, $server) {
		$this->connection = &$connection;
		$this->stream = new Stream(&$connection->stream);
		$this->server = $server;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$this->connection->on('data', function($data) {
			Hex::dump($data);
			$this->server->handlePacket($data);
		});
	}
}
