<?php

namespace HHVMCraft\Core\Helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MLogger;

class Logger {
	const PREFIX = " HHVMCraft >> ";
	const ERROR_PREFIX = "[ERROR]";
	const WARNING_PREFIX = "[WARNING]";
	const LOG_PREFIX = "[LOG]";

	public $options;
	public $PacketLog;

	public function __construct() {
		if (!file_exists("logs/")) {
			mkdir("logs/");
		}

		$this->PacketLog = new MLogger('PacketLogger');
		$this->PacketLog->pushHandler(new StreamHandler('logs/packet_log'), MLogger::INFO);
		$this->ServerLog = new MLogger('ServerLogger');
#		$this->OutLog = new MLogger('OutLogger');
#		$this->OutLog->pushHandler(new StreamHandler('logs/out_log'), MLogger::INFO);
	}

	public function throwLog($msg) {
		$response = $this::PREFIX . $msg . PHP_EOL;
		$this->ServerLog->addInfo($response);
#		$this->OutLog->addInfo($response);
	}

	public function throwWarning($msg) {
		$response = $this::PREFIX . $msg . PHP_EOL;
		$this->ServerLog->addWarning($response);
	}

	public function throwError($msg) {
		$response = $this::PREFIX . $msg . PHP_EOL;
		$this->ServerLog->addError($response);
	}

	public function logPacket($packet) {
		$this->PacketLog->addInfo($packet);
	}
}
