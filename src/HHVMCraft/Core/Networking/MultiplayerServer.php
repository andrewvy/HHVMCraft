<?php
/**
* MultiplayerServer is part of HHVMCraft - a Minecraft server implemented in PHP
* - The central networking and game loop controller.
* - Handles the gameloop and entityloop.
* - Handles the connection/disconnection of clients.
* - Handles packets to be read.
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/
namespace HHVMCraft\Core\Networking;

use Evenement\EventEmitter;
use HHVMCraft\API\BlockRepository;
use HHVMCraft\API\CraftingRepository;
use HHVMCraft\Core\Entities\EntityManager;
use HHVMCraft\Core\Helpers\Logger;
use HHVMCraft\Core\Networking\Handlers;
use HHVMCraft\Core\Networking\PackerReader;

use HHVMCraft\Core\Networking\Packets\ChatMessagePacket;
use HHVMCraft\Core\Networking\Packets\KeepAlivePacket;

use HHVMCraft\Core\World\World;
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

		$this->BlockRepository = new BlockRepository();
		$this->CraftingRepository = new CraftingRepository();

		$this->PacketHandler = new PacketHandler($this);
		$this->World = new World("Flatland", $this->BlockRepository);

		$this->EntityManager = new EntityManager($this, $this->World);

		$this->Logger = new Logger();
	}

	public function start($port) {
		$this->socket->on('connection', function ($connection) {
			$this->Logger->throwLog("New Connection");
			$this->acceptClient($connection);
		});

		$this->socket->listen($port);

		$this->loop->addPeriodicTimer($this->tickRate, function () {
			$this->EntityManager->update();
		});

		$this->loop->addPeriodicTimer(1, function () {
			$this->emitKeepAlive();
			$this->World->updateTime();
		});

		$this->Logger->throwLog("Listening on address: " . $this->address . ":" . $port);
		$this->loop->run();
	}

	public function acceptClient($connection) {
		$client = new Client($connection, $this);
		$this->Clients[$client->uuid] = $client;
	}

	public function handlePacket($client) {
		$packet = $this->PacketReader->readPacket($client);

		if ($packet) {
			$this->PacketHandler->handlePacket($packet, $client, $this);
		}
	}

	public function writePacket($packet, $client) {
		$this->PacketReader->writePacket($packet, $client);
	}

	public function handleDisconnect($Client, $ServerOriginated = false, $reason="") {
		if ($ServerOriginated) {
			$Client->disconnectWithReason($reason);
		} else {
			$Client->disconnect();
		}

		unset($this->Clients[$Client->uuid]);

		$this->sendMessage($Client->username." has disconnected from the server.");
	}

	public function emitKeepAlive() {
		foreach ($this->Clients as $Client) {
			$Client->enqueuePacket(new KeepAlivePacket());
		}
	}

	public function sendMessage($message="") {
		$this->Logger->throwLog($message);

		foreach ($this->Clients as $Client) {
			$Client->enqueuePacket(new ChatMessagePacket(
				$message
			));
		}
	}
}
