<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Handlers;

use HHVMCraft\API\Coordinates3D;
use HHVMCraft\Core\Networking\Packets\UpdateHealthPacket;

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
			case "/buffer":
				$count = "Buffer is: ".count($Client->streamWrapper->streamBuffer);
				$Client->sendMessage($count);
				break;
			case "/ping":
				$Client->sendMessage("Pong!");
				break;
			case "/kill":
				$Client->enqueuePacket(new UpdateHealthPacket());
				break;
			case "/sethealth":
				if (!is_numeric($args[1])) {
					return $Client->sendMessage("Number needed!");
				}

				$Client->enqueuePacket(new UpdateHealthPacket($args[1]));
				break;
			case "/getpos":
				$x = $Client->PlayerEntity->Position->x;
				$y = $Client->PlayerEntity->Position->y;
				$z = $Client->PlayerEntity->Position->z;
				$coords = new Coordinates3D($x, $y, $z);

				$Client->sendMessage($coords->toString());
				break;
			default:
				$Client->sendMessage("Command not recognized!");
		}
	}

	# TODO (vy): Port commands into their own functions here
}
