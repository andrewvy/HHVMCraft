<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Handlers;

class ChatHandler {
	public static function HandleChatMessage($Packet, $Client, $Server) {
		if ($Packet->message[0] == "/") {
			self::handleCommand($Packet->message, $Client, $Server);
		} else {
			$message = "<" . $Client->username . "> " . $Packet->message;
			$Server->sendMessage($message);
		}
	}

	public static function handleCommand($message="", $Client, $Server) {
		$args = explode(" ", $message);
		switch ($args[0]) {
			case "/ping":
				$Client->sendMessage("Pong!");
				break;
			default:
				$Client->sendMessage("Command not recognized!");
		}
	}

	# TODO (vy): Port commands into their own functions here
}
