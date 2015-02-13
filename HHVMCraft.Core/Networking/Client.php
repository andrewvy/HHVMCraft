<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Networking/Stream.php";
require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\StreamWrapper;

class Client {
	public $server;
	public $connection;
	public $streamWrapper;

	public $lastSuccessfulPacket;
	public $PacketQueue = [];
	public $PacketQueueCount = 0;

	public $Username;

	public function __construct($connection, $server) {
		$this->connection = $connection;
		$this->streamWrapper = new StreamWrapper($connection->stream);
		$this->server = $server;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$this->connection->on('data', function($data) {
			$this->streamWrapper->data($data);
			$this->server->handlePacket($this);
		});
	}

	public function enqueuePacket($packet) {
		$this->PacketQueueCount++;
		array_push($this->PacketQueue, $packet);
	}

	public function dequeuePacket() {
		if ($this->PacketQueueCount == 0) {
			return false;
		} else {
			$this->PacketQueueCount--;
			return array_shift($this->PacketQueue);
		}
	}	
}
