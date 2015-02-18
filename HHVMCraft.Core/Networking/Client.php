<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Networking/Stream.php";
require "HHVMCraft.Core/Helpers/HexDump.php";
require "HHVMCraft.Core/Entities/PlayerEntity.php";
require "HHVMCraft.Core/Networking/Packets/ChunkPreamblePacket.php";
require "HHVMCraft.Core/Windows/InventoryWindow.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\StreamWrapper;
use HHVMCraft\Core\Networking\Packets\ChunkPreamblePacket;
use HHVMCraft\Core\Networking\Packets\ChunkDataPacket;
use HHVMCraft\Core\Entities\PlayerEntity;
use HHVMCraft\Core\Windows\InventoryWindow;

class Client {
	public $server;
	public $World;
	public $connection;
	public $streamWrapper;
	public $Disconnected = false;

	public $lastSuccessfulPacket;
	public $PacketQueue = [];
	public $PacketQueueCount = 0;

	public $username;
	public $PlayerEntity;
	public $knownEntities = [];

	public $loadedChunks = [];
	public $Inventory;

	public function __construct($connection, $server) {
		$this->connection = $connection;
		$this->streamWrapper = new StreamWrapper($connection->stream);
		$this->server = $server;
		$this->World = $server->World;
		$this->Inventory = new InventoryWindow($server->CraftingRepository);
		$this->setupPacketListener();
	}

	public function setupPacketListener() {
		$this->connection->on('data', function($data) {
			$this->streamWrapper->data($data);
			Hex::dump($data);
			$this->server->handlePacket($this);
		});
	}

	public function enqueuePacket($packet) {
		$this->PacketQueueCount++;
		array_push($this->PacketQueue, $packet);
	}

	public function dequeuePacket() {
		if ($this->PacketQueueCount == 0) {
			return false;
		} else {
			$this->PacketQueueCount--;
			return array_shift($this->PacketQueue);
		}
	}	

	public function loadChunk($Coordinates2D) {
		$chunk = $this->World->getChunk($Coordinates2D);
		$this->enqueuePacket(new ChunkPreamblePacket($chunk->x, $chunk->z));
		$this->enqueuePacket($this->createChunkPacket($chunk));
		
		$serialized = $chunk->x.":".$chunk->z;
		$this->loadedChunks[$serialized] = true;
	}

	public function unloadChunk($Coordinates2D) {
		$this->enqueuePacket(new ChunkPreamablePacket($Coordinates2D->x, $Coordiantes2D->z, false));
		$serialized = $chunk->x.":".$chunk->z;
		unset($this->loadedChunks[$serialized]);
		$this->loadedChunks = array_values($array);
	}
}
