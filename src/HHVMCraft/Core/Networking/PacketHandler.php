<?php
/**
 * PacketHandler is part of HHVMCraft - a Minecraft server implemented in PHP
 * - This class is responsible for dispersing packets to the correct PacketHandler.
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking;

use HHVMCraft\Core\Networking\Handlers;
use HHVMCraft\Core\Networking\Packets;

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
		$this->Handlers[Packets\KeepAlivePacket::id] = '\HHVMCraft\Core\Networking\Handlers\DataHandler::HandleKeepAlive';
		$this->Handlers[Packets\DisconnectPacket::id] = '\HHVMCraft\Core\Networking\Handlers\DataHandler::HandleDisconnect';
		$this->Handlers[Packets\ChatMessagePacket::id] = '\HHVMCraft\Core\Networking\Handlers\ChatHandler::HandleChatMessage';

		$this->Handlers[Packets\HandshakePacket::id] = '\HHVMCraft\Core\Networking\Handlers\LoginHandler::HandleHandshake';
		$this->Handlers[Packets\LoginRequestPacket::id] = '\HHVMCraft\Core\Networking\Handlers\LoginHandler::HandleLoginRequest';

		$this->Handlers[Packets\PlayerGroundedPacket::id] = '\HHVMCraft\Core\Networking\Handlers\PlayerHandler::HandleGrounded';
		$this->Handlers[Packets\PlayerPositionPacket::id] = '\HHVMCraft\Core\Networking\Handlers\PlayerHandler::HandlePosition';
		$this->Handlers[Packets\PlayerLookPacket::id] = '\HHVMCraft\Core\Networking\Handlers\PlayerHandler::HandleLook';
		$this->Handlers[Packets\PlayerPositionAndLookPacket::id] = '\HHVMCraft\Core\Networking\Handlers\PlayerHandler::HandlePositionAndLook';
		$this->Handlers[Packets\RespawnPacket::id] = '\HHVMCraft\Core\Networking\Handlers\PlayerHandler::HandleRespawn';
	}

	public function handlePacket($packet, $client, $server) {
		$func = $this->Handlers[$packet::id];
		if ($func) {
			// Through some fun hackery, the correct handler function
			// is called by figuring out the handler by packet ID.
			// This allows us to have a base class Handler around generic action
			// while specificing a specific function to handle the packet.
			$func($packet, $client, $server);
		}
	}
}
