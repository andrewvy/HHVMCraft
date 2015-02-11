<?php

namespace HHVMCraft\Core\Networking;

require 'Client.php';

class MultiplayerServer {
	public $connectCb;
	public $sock;
	public $address;
	public $eventBase;
	public $acceptCb;
	public $Clients;

	function __construct($address) {
		$this->address = $address;
		$this->eventBase = event_base_new();
		$this->acceptCb = function($req, $events, $server) {
			$socket = stream_socket_accept($req);
			$client = new \HHVMCraft\Core\Networking\Client($socket, $server);
			$this->Clients.push($client);
			$cb = $this->connectCb;
			if ($cb) {
				$cb($client);
			};
		};
	}

	public function onConnect($func) {
		$this->connectCb = $func;
	}

	public function start($port) {
		$this->sock = stream_socket_server($this->address);
		$event = event_new();
		
		event_set(
			$event,
			$this->sock,
			EV_READ|EV_PERSIST,
			$this->acceptCb,
			$this
		);

		event_base_set($event, $this->eventBase);
		event_add($event);
		event_base_loop($this->eventBase);		

		echo "Listening on address: " + $this->address + ":" + $port;
	}
}
