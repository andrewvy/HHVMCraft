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
		$this->Handlers = new \SplFixedArray(256);

		$this->registerHandlers();

		$dataHandler = new Handlers\DataHandler();
		$chatHandler = new Handlers\ChatHandler();
		$loginHandler = new Handlers\LoginHandler();
		$playerHandler = new Handlers\PlayerHandler();

	}

	public function registerHandlers() {
		$this->Handlers[Packets\KeepAlivePacket::id] = function($packet, $client, $server) { Handlers\DataHandler::HandleKeepAlive($packet, $client, $server); };
		$this->Handlers[Packets\DisconnectPacket::id] = function($packet, $client, $server) { Handlers\DataHandler::HandleDisconnect($packet, $client, $server); };
		$this->Handlers[Packets\ChatMessagePacket::id] = function($packet, $client, $server) { Handlers\ChatHandler::HandleChatMessage($packet, $client, $server); };

		$this->Handlers[Packets\HandshakePacket::id] = function($packet, $client, $server) { Handlers\LoginHandler::HandleHandshake($packet, $client, $server); };
		$this->Handlers[Packets\LoginRequestPacket::id] = function($packet, $client, $server) { Handlers\LoginHandler::HandleLoginRequest($packet, $client, $server); };

		$this->Handlers[Packets\PlayerGroundedPacket::id] = function($packet, $client, $server) { Handlers\PlayerHandler::HandleGrounded($packet, $client, $server); };
		$this->Handlers[Packets\PlayerPositionPacket::id] = function($packet, $client, $server) { Handlers\PlayerHandler::HandlePosition($packet, $client, $server); };
		$this->Handlers[Packets\PlayerLookPacket::id] = function($packet, $client, $server) { Handlers\PlayerHandler::HandleLook($packet, $client, $server); };
		$this->Handlers[Packets\PlayerPositionAndLookPacket::id] = function($packet, $client, $server) { Handlers\PlayerHandler::HandlePositionAndLook($packet, $client, $server); };
		$this->Handlers[Packets\RespawnPacket::id] = function($packet, $client, $server) { Handlers\PlayerHandler::HandleRespawn($packet, $client, $server); };
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
