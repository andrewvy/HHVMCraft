<?php

namespace HHVMCraft\Core\Networking;

class Client {
	public $server;
	public $stream;
	public $buffer;

	public $writeBuffer;
	public $readArray = [];
	public $offset;

	public $lastSuccessfulPacket;

	public function __construct($stream) {
		$this->stream = $stream;

		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$stream->on('data', function($data) use ($client) {
			Hex::dump($data);

		});
	}

	public function flushWriteBuffer() {
		$this->write_pending = false;
		socket_write($this->stream, $this->writeBuffer)
	}

}
