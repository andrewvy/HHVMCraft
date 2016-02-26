<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

namespace HHVMCraft\Core\Networking\Handlers;

use HHVMCraft\API\Coordinates3D;
use HHVMCraft\Core\Networking\Packets\WindowItemsPacket;
use HHVMCraft\Core\Networking\Packets\UpdateHealthPacket;
use HHVMCraft\Core\Networking\Packets\BlockChangePacket;

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
		$args_count = count($args);

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
			case "/give":
				// give a stack of the given item id to the client
				// /give 5 <- gives 64 of item_id: 5
				// /give 5 32 <- gives 32 of item_id: 5

				if (!is_numeric($args[1])) {
					return $Client->sendMessage("/give [id] [count]. Numerical Item ID needed!");
				}

				if ($args_count == 3 && !is_numeric($args[2])) {
					return $Client->sendMessage("/give [id] [count]. Numerical Item count needed!");
				} else if ($args_count == 3) {
					$item_count = (int) $args[2];
				} else {
					$item_count = 0x40;
				}

				$item_id = (int) $args[1];

				if ($item_id > 0x00) {
					$Client->setItem($item_id, $item_count);
					$Client->enqueuePacket(new WindowItemsPacket(0, $Client->Inventory->getSlots()));
					return $Client->sendMessage("Successfully gave a stack of " . $args[1]);
				} else {
					return $Client->sendMessage("Item ID given was not a valid item id.");
				}

				break;
			case "/heart":
				return $Client->sendMessage("<3");
				break;
			case "/rename":
				if ($args_count != 2) { return; }

				$Server->sendMessage($Client->username . " has changed their name to: " . $args[1]);

				$Client->username = $args[1];
				$Client->PlayerEntity->username = $args[1];
				break;
			default:
				$Client->sendMessage("Command not recognized!");
		}
	}

	# TODO (vy): Port commands into their own functions here
}
