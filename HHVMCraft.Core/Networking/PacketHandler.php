<?php

namespace HHVMCraft\Core\Networking;

require "Packets/HandshakePacket.php";
require "Packets/LoginRequestPacket.php";
require "Handlers/LoginHandler.php";

use HHVMCraft\Core\Networking\Packets;
use HHVMCraft\Core\Networking\Handlers;

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
		$this->Handlers[Packets\HandshakePacket::id] = "\Handlers\LoginHandler::HandleHandshakePacket";
		$this->Handlers[Packets\LoginRequestPacket::id] = '\Handlers\LoginHandler::HandleLoginRequestPacket';
	}

	public function handlePacket($packet, $client, $server) {
		if ($this->Handlers[$packet::id]) {
			call_user_func('\HHVMCraft\Core\Networking'.$this->Handlers[$packet::id], $packet, $client, $server);
		} else {
			echo " >> No handler for packet ID: ".$packet::id."\n";
		}	
	}
}
