<?php

namespace HHVMCraft\Core\Networking;

require "vendor/autoload.php";
require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Networking\Client;
use Evenement\EventEmitter;
use React\Socket\Server;
use HHVMCraft\Core\Helpers\Hex;


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
			echo " >> New Connection \n";
			
			$this->acceptClient($client);	
			$client->on('data', function($data) use ($client) {
				Hex::dump($data);
				socket_write($client->stream, 0x02FF0106);
			});
		});
		
		$this->socket->listen($port);
		$this->loop->run();
		
		echo " >> Listening on address: " + $this->address + ":" + $port + "\n";
	}


}
