<?php

namespace HHVMCraft\Core\Networking;

use HHVMCraft\API\ItemStack;
use HHVMCraft\API\Coordinates2D;
use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\Packets\ChatMessagePacket;
use HHVMCraft\Core\Networking\Packets\ChunkDataPacket;
use HHVMCraft\Core\Networking\Packets\ChunkPreamblePacket;
use HHVMCraft\Core\Networking\Packets\DisconnectPacket;
use HHVMCraft\Core\Windows\InventoryWindow;

class Client {
	public $Server;
	public $World;
	public $uuid;
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
	public $chunkRadius = 1;
	public $Inventory;

	public $pktCount = 0;

	public function __construct($connection, $server) {
		$this->uuid = uniqid("client");
		$this->connection = $connection;
		$this->streamWrapper = new StreamWrapper($connection);
		$this->Server = $server;
		$this->World = $server->World;
		$this->Inventory = new InventoryWindow($server->CraftingRepository);
		$this->setItem(0x01, 0x40, 0x00, 3, 0);
		$this->setupPacketListener();
		$this->pktCount = 0;
	}

	public function setupPacketListener() {
		$this->connection->on('data', function ($data) {
			$this->pktCount++;
			$this->streamWrapper->data($data);

			while ($this->pktCount > 0) {
				$this->Server->handlePacket($this);
				$this->pktCount--;
			}
		});
	}

	//    1     2      3
	//
	//
	//    4   player   5
	//
	//
	//    6     7      8

	public function updateChunks() {
		$offsetX = $this->PlayerEntity->Position->x >> 4;
		$offsetZ = $this->PlayerEntity->Position->z >> 4;
		$startX = $offsetX - $this->chunkRadius;
		$startZ = $offsetZ - $this->chunkRadius;

		for ($x = $startX; $x < ($offsetX + $this->chunkRadius * 2); $x++) {
			for ($z = $startZ; $z < ($offsetZ + $this->chunkRadius * 2); $z++) {
				$Coordinates2D = new Coordinates2D($x, $z);
				$this->loadChunk($Coordinates2D);
			}
		}
	}

	public function createChunkPacket($chunk) {
		return new ChunkDataPacket(
			$chunk->x,
			0,
			$chunk->z,
			$chunk::Width,
			$chunk::Height,
			$chunk::Depth,
			gzcompress($chunk->deserialize())
		);
	}

	public function enqueuePacket($packet) {
		$this->Server->writePacket($packet, $this);
	}

	public function loadChunk(Coordinates2D $Coordinates2D) {
		$serialized = $Coordinates2D->toString();

		$chunk = $this->World->generateChunk($Coordinates2D);
		$preamble = new ChunkPreamblePacket($Coordinates2D->x, $Coordinates2D->z);
		$data = $this->createChunkPacket($chunk);
		$this->enqueuePacket($preamble);
		$this->enqueuePacket($data);

		$this->loadedChunks[$serialized] = true;
	}

	public function unloadChunk(Coordinates2D $Coordinates2D) {
		$serialized = $Coordinates2D->toString();

		if (in_array($serialized, $this->loadedChunks)) {
			$this->enqueuePacket(new ChunkPreamablePacket($Coordinates2D->x, $Coordiantes2D->z, false));
			$serialized = $chunk->x . ":" . $chunk->z;
			unset($this->loadedChunks[$serialized]);
			$this->loadedChunks = array_values($array);
		}
	}

	public function disconnect() {
		$this->streamWrapper->close();
		$this->loadedChunks = [];
		$this->connection->handleClose();
	}

	public function disconnectWithReason($reason) {
		$this->loadedChunks = [];
		$this->enqueuePacket(new DisconnectPacket($reason));
		$this->connection->handleClose();
	}

	public function sendMessage($message="") {
		$this->enqueuePacket(new ChatMessagePacket(
			$message
		));
	}

	public function setItem($id=0x00, $amount=0x40, $metadata=0x00, $window=3, $slot=0) {
		$this->Inventory->WindowAreas[$window]->Items[$slot] = new ItemStack($id, $amount, $metadata);
	}
}
