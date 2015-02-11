<?php

namespace HHVMCraft\Core\Networking;

class Connection {
	public $sock;
	public $eventBuff;
	public $tcpServer;
	public $dataCb;
	public $disconnectCb;
	public $writePending = FALSE;
	public $closePending = FALSE;

	function __construct($socket, $server) {
		$this->sock = $socket;
		$this->tcpServer = $server;

		stream_set_blocking($socket, 0);

		$this->eventBuff = event_buffer_new(
			$socket,
			'\HHVMCraft\Core\Callback\EventReadCallback',
			'\HHVMCraft\Core\Callback\EventWriteCallback',
			'\HHVMCraft\COre\Callback\EventErrorCallback',
			$this
		);

		event_buffer_base_set($this->eventBuff, $server->eventBase);
		event_buffer_watermark_set($this->eventBuff, EV_READ | EV_WRITE, 0, 0xffffff);
		event_buffer_enable($this->eventBuff, EV_READ | EV_WRITE | EV_PERSIST);
	}

	function write($bytes) {
	
	}

}
