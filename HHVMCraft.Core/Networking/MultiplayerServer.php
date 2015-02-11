<?php

namespace HHVMCraft\Core\Networking;
use HHVMCraft\Core\Networking\Client;

require "vendor/autoload.php";
use Evenement\EventEmitter;
use React\Socket\Server;

class MultiplayerServer extends EventEmitter {
	public $connectCb;
	public $address;
	public $eventBase;
	public $acceptCb;
	public $Clients = [];

	public $loop;
	public $socket;

	public function __construct($address) {
		$this->address = $address;
		$this->loop = \React\EventLoop\Factory::create();
		$this->socket = new Server($this->loop);
	}

	public function acceptClient($client) {
		array_push($this->Clients, $client);
	}

	public function start($port) {
		$this->socket->on('connection', function($client) {
			echo " >> New Connection";
			
			$this->acceptClient($client);
			socket_write($client->stream,"Hello world!");
			$client->close();
		});
		
		$this->socket->listen($port);
		$this->loop->run();
		
		echo " >> Listening on address: " + $this->address + ":" + $port;
	}
}
