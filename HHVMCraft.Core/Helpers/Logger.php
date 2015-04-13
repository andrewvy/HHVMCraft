<?php

namespace HHVMCraft\Core\Helpers;

class Logger {
	const PREFIX = " HHVMCraft >> ";
	const ERROR_PREFIX = "[ERROR]";
	const WARNING_PREFIX = "[WARNING]";
	const LOG_PREFIX = "[LOG]";

	public $options;

	public function __construct($options) {
		$this->options = $options;
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
}
