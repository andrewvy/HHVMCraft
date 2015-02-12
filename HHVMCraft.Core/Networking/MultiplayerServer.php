<?php

namespace HHVMCraft\Core\Networking;

require "vendor/autoload.php";

use HHVMCraft\Core\Networking\Client;
use Evenement\EventEmitter;
use React\Socket\Server;

class MultiplayerServer extends EventEmitter {
	public $address;
	public $Clients = [];
	public $PacketHandlers = [];

	public $loop;
	public $socket;

	public function __construct($address) {
		$this->address = $address;
		$this->loop = \React\EventLoop\Factory::create();
		$this->socket = new Server($this->loop);
	}

	public function acceptClient($connection) {
		array_push($this->Clients, new Client($connection->stream));
	}

	public function start($port) {
		$this->socket->on('connection', function($connection) {
			echo " >> New Connection \n";
			
			$this->acceptClient($connection);	
		});
		
		$this->socket->listen($port);
		$this->loop->run();
		
		echo " >> Listening on address: " + $this->address + ":" + $port + "\n";
	}

	public function registerPacketHandlers($id, $handler) {
		$this->PacketHandlers[$id] = $handler
	}
}
