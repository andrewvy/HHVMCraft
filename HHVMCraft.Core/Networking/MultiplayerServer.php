<?php

namespace HHVMCraft\Core\Networking;

require "vendor/autoload.php";
require "HHVMCraft.Core/Networking/PacketReader.php";
require "HHVMCraft.Core/Networking/PacketHandler.php";
require "HHVMCraft.Core/Networking/Client.php";
require "HHVMCraft.Core/Entities/EntityManager.php";
require "HHVMCraft.Core/World/World.php";

use HHVMCraft\Core\Networking\Client;
use HHVMCraft\Core\Networking\PacketReader;
use HHVMCraft\Core\Networking\PacketHandler;
use HHVMCraft\Core\Networking\Handlers;
use HHVMCraft\Core\Entities\EntityManager;
use HHVMCraft\Core\World\World;

use Evenement\EventEmitter;
use React\Socket\Server;

class MultiplayerServer extends EventEmitter {
	public $address;
	public $Clients = [];

	public $PacketHandler;
	public $PacketReader;
	public $EntityManager;
	public $World;

	public $loop;
	public $socket;

	public $tickRate = 0.05;

	public function __construct($address) {
		$this->address = $address;
		$this->loop = \React\EventLoop\Factory::create();
		$this->socket = new Server($this->loop);

		$this->PacketReader = new PacketReader();
		$this->PacketReader->registerPackets();

		$this->PacketHandler = new PacketHandler($this);
		$this->EntityManager = new EntityManager($this);
		$this->World = new World("Flatland", $BlockProvider);
	}

	public function acceptClient($connection) {
		array_push($this->Clients, new Client($connection, $this));
	}

	public function start($port) {
		$this->socket->on('connection', function($connection) {
			echo " >> New Connection \n";
			
			$this->acceptClient($connection);	
		});
		
		$this->socket->listen($port);

		$this->loop->addPeriodicTimer($this->tickRate, function() {
			$this->gameLoop();
		});

		$this->loop->run();
		
		echo " >> Listening on address: " + $this->address + ":" + $port + "\n";
	}

	public function handlePacket($client) {
		$packet = $this->PacketReader->readPacket($client);
		if ($packet) {
			$this->PacketHandler->handlePacket($packet, $client, $this);
		} else {
			echo " >> Bad Packet \n";	
		}
	}

	public function gameLoop() {
		foreach ($this->Clients as &$Client) {
			while ($Client->PacketQueueCount > 0) {
				$Packet = $Client->dequeuePacket();
				$this->PacketReader->writePacket($Packet, $Client);
			}
		}
	}
}
