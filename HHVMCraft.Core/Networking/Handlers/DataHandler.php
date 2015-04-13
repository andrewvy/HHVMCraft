<?php

namespace HHVMCraft\Core\Networking\Handlers;

class DataHandler {

	public static function HandleKeepAlivePacket() {
		// Do nothing for now
	}

	public static function HandleChatMessage() {

	}

	public static function HandleDisconnect($ClientBound=true, $ServerBound=false) {
		// We want to know if the client has disconnected from the server
		// or if the server has disconnected the client.

	}
}
