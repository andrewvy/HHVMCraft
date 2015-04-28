<?php

namespace HHVMCraft\Core\Networking;

use HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Networking\Handlers;

// PacketHandler
// This class is responsible for dispersing packets to the correct PacketHandler.

class PacketHandler {
	public $server;
	public $LoginHandler;
	public $Handlers;

	public function __construct($server) {
		$this->server = $server;
		$this->Handlers = new \ArrayObject();

		$this->registerHandlers();
	}

	public function registerHandlers() {
		$this->Handlers[Packets\KeepAlivePacket::id] = '\Handlers\DataHandler::HandleKeepAlive';
		$this->Handlers[Packets\DisconnectPacket::id] = '\Handlers\DataHandler::HandleDisconnect';
		$this->Handlers[Packets\ChatMessagePacket::id] = '\Handlers\DataHandler::HandleChatMessage';

		$this->Handlers[Packets\HandshakePacket::id] = '\Handlers\LoginHandler::HandleHandshake';
		$this->Handlers[Packets\LoginRequestPacket::id] = '\Handlers\LoginHandler::HandleLoginRequest';

		$this->Handlers[Packets\PlayerGroundedPacket::id] = '\Handlers\PlayerHandler::HandleGrounded';
		$this->Handlers[Packets\PlayerPositionPacket::id] = '\Handlers\PlayerHandler::HandlePosition';
		$this->Handlers[Packets\PlayerLookPacket::id] = '\Handlers\PlayerHandler::HandleLook';
		$this->Handlers[Packets\PlayerPositionAndLookPacket::id] = '\Handlers\PlayerHandler::HandlePositionAndLook';
	}

	public function handlePacket($packet, $client, $server) {
		if ($this->Handlers[$packet::id]) {
			// Through some fun hackery, the correct handler function
			// is called by figuring out the handler by packet ID.
			// This allows us to have a base class Handler around generic action
			// while specificing a specific function to handle the packet.

			call_user_func('\HHVMCraft\Core\Networking'.$this->Handlers[$packet::id], $packet, $client, $server);
		} else {
			$server->Logger->throwWarning("No handler for packet ID: ".$packet::id);
		}
	}
}
