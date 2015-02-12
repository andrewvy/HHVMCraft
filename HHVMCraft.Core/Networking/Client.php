<?php

namespace HHVMCraft\Core\Networking;
use HHVMCraft\Core\Networking\Connection;

class Client {
	public $stream;
	public $buffer;

	public function __construct($stream) {
		$this->stream = $stream;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$stream->on('data', function($data) use ($client) {
			Hex::dump($data);
			socket_write($client->stream, 0x02FF0106);
		});
	}
}
