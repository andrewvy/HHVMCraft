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
			echo " >> New Connection \n";
			
			$this->acceptClient($client);	

			socket_write($client->stream, 0x022D);
			$client->on('data', function($data) use ($client) {
				$this->hex_dump($data);
			});
		});
		
		$this->socket->listen($port);
		$this->loop->run();
		
		echo " >> Listening on address: " + $this->address + ":" + $port + "\n";
	}

	public function hex_dump($data, $newline="\n") {
		static $from = '';
		static $to = '';

		static $width = 16; # number of bytes per line

		static $pad = '.'; # padding for non-visible characters

		if ($from==='') {
			for ($i=0; $i<=0xFF; $i++) {
				$from .= chr($i);
				$to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
			}
		}

		$hex = str_split(bin2hex($data), $width*2);
		$chars = str_split(strtr($data, $from, $to), $width);

		$offset = 0;
		foreach ($hex as $i => $line) {
			echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2)) . ' [' . $chars[$i] . ']' . $newline;
			$offset += $width;
		}
	}

}
