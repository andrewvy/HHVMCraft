<?php

namespace HHVMCraft\Core\Helpers;

require "vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Logger {
	const PREFIX = " HHVMCraft >> ";
	const ERROR_PREFIX = "[ERROR]";
	const WARNING_PREFIX = "[WARNING]";
	const LOG_PREFIX = "[LOG]";

	public $options;
	public $PacketLog;

	public function __construct($options) {
		$this->options = $options;
		$this->PacketLog = new Logger('PacketLogger');
		$this->PacketLog->pushHandler(new StreamHandler('../log/packet_log.log', Logger::INFO));
	}

	public function throwLog($msg) {
		echo $this::LOG_PREFIX.$this::PREFIX.$msg.PHP_EOL;
	}

	public function throwWarning($msg) {
		echo $this::WARNING_PREFIX.$this::PREFIX.$msg.PHP_EOL;
	}

	public function throwError($msg) {
		echo $this::ERROR_PREFIX.$this::PREFIX.$msg.PHP_EOL;
	}

	public function logPacket($packet) {
		$this->PacketLog->addInfo($packet::id);
	}
}
