<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Helpers;

use Monolog\Logger as MLogger;
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

		# Packet Logger
		$this->PacketLog = new MLogger('PacketLogger');
		$this->PacketLog->pushHandler(new StreamHandler('logs/packet_log.log'), MLogger::INFO);
		$this->ServerLog = new MLogger('ServerLogger');

	}

	public function throwLog($msg) {
		$response = $this::PREFIX.$msg.PHP_EOL;
		$this->ServerLog->addInfo($response);
	}

	public function throwWarning($msg) {
		$response = $this::PREFIX.$msg.PHP_EOL;
		$this->ServerLog->addWarning($response);
	}

	public function throwError($msg) {
		$response = $this::PREFIX.$msg.PHP_EOL;
		$this->ServerLog->addError($response);
	}

	public function logPacket($packet) {
		$this->PacketLog->addInfo($packet);
	}
}
