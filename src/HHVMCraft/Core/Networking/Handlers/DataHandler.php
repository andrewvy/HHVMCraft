<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking\Handlers;

class DataHandler {

	public static function HandleKeepAlive() {
		// Do nothing for now
	}

	public static function HandleChatMessage($Packet, $Client, $Server) {
		$message = "<" . $Client->username . "> " . $Packet->message;
		$Server->sendMessage($message);
	}

	public static function HandleDisconnect($Packet, $Client, $Server) {
		// If called, this means we've read a serverbound packet that a client has disconnected.

		$Server->Logger->throwLog("Client has disconnected for reason: " . $Packet->reason);

		$Server->handleDisconnect($Client);
	}
}
