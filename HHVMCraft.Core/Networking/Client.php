<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Helpers/HexDump.php";
use HHVMCraft\Core\Helpers\Hex;

class Client {
	public $server;
	public $connection;
	public $stream;
	public $buffer;

	public $writeBuffer;
	public $readArray = [];
	public $offset;

	public $lastSuccessfulPacket;

	public function __construct(&$connection) {
		$this->connection = &$connection;
		$this->stream = &$connection->stream;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$this->connection->on('data', function($data) {
			Hex::dump($data);
		});
	}

	public function flushWriteBuffer() {
		$this->write_pending = false;
		socket_write($this->stream, $this->writeBuffer);
	}

}
