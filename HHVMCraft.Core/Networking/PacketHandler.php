<?php

namespace HHVMCraft\Core\Networking;

require "Packets/HandshakePacket.php";
require "Packets/LoginRequestPacket.php";
require "Packets/KeepAlivePacket.php";
require "Packets/PlayerGroundedPacket.php";
require "Packets/PlayerPositionPacket.php";
require "Packets/PlayerLookPacket.php";
require "Packets/PlayerPositionAndLookPacket.php";


require "Handlers/LoginHandler.php";
require "Handlers/DataHandler.php";
require "Handlers/PlayerHandler.php";

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
		$this->Handlers[Packets\KeepAlivePacket::id] = '\Handlers\DataHandler::HandleKeepAlivePacket';
		$this->Handlers[Packets\HandshakePacket::id] = '\Handlers\LoginHandler::HandleHandshakePacket';
		$this->Handlers[Packets\LoginRequestPacket::id] = '\Handlers\LoginHandler::HandleLoginRequestPacket';

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
			$server->Logger->throwWarning("No hanlder for packet ID: ".$packet::id);
		}
	}
}
