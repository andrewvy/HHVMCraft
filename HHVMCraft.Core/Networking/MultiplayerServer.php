<?php

namespace HHVMCraft\Core\Networking;

require "vendor/autoload.php";
require "HHVMCraft.Core/Networking/PacketReader.php";
require "HHVMCraft.Core/Networking/PacketHandler.php";

use HHVMCraft\Core\Networking\Client;
use HHVMCraft\Core\Networking\PacketReader;
use HHVMCraft\Core\Networking\PacketHandler;

use Evenement\EventEmitter;
use React\Socket\Server;

class MultiplayerServer extends EventEmitter {
	public $address;
	public $Clients = [];
	public $PacketHandlers = [];

	public $loop;
	public $socket;
	public $PacketReader;

	public function __construct($address) {
		$this->address = $address;
		$this->loop = \React\EventLoop\Factory::create();
		$this->socket = new Server($this->loop);

		$this->PacketReader = new PacketReader();
		$this->PacketReader->registerPackets();

		// PacketHandler::registerHandlers($this);
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
		$this->PacketHandlers[$id] = $handler;
	}

	public function handlePacket($client, $data) {
		$packet = $this->PacketReader.read($data);
		if ($this->PacketHandlers[$packet::id]) {
			$this->PacketHandler[$packet]();
		}
	}
}
