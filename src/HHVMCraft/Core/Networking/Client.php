<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Networking;

use HHVMCraft\API\Coordinates2D;
use HHVMCraft\Core\Networking\Packets\ChunkDataPacket;
use HHVMCraft\Core\Networking\Packets\ChunkPreamblePacket;
use HHVMCraft\Core\Networking\Packets\DisconnectPacket;
use HHVMCraft\Core\Windows\InventoryWindow;

class Client {
  public $Server;
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
  public $chunkRadius = 5;
  public $Inventory;

  public function __construct($connection, $server) {
    $this->connection = $connection;
    $this->streamWrapper = new StreamWrapper($connection->stream);
    $this->Server = $server;
    $this->World = $server->World;
    $this->Inventory = new InventoryWindow($server->CraftingRepository);
    $this->setupPacketListener();
  }

  public function setupPacketListener() {
    $this->connection->on('data', function ($data) {
      $this->streamWrapper->data($data);
      $this->Server->handlePacket($this);
    });
  }

  public function dequeuePacket() {
    if ($this->PacketQueueCount == 0) {
      return false;
    }
    else {
      $this->PacketQueueCount--;

      return array_shift($this->PacketQueue);
    }
  }

  public function updateChunks() {
    for ($i = 0; $i < 1; $i++) {
      for ($j = 0; $j < 1; $j++) {
        $Coordinates2D = new Coordinates2D($i, $j);
        $chunk = $this->World->generateChunk($Coordinates2D);
        $preamble = new ChunkPreamblePacket($Coordinates2D->x, $Coordinates2D->z);
        $data = $this->createChunkPacket($chunk);
//      $this->enqueuePacket($preamble);
//      $this->enqueuePacket($data);
      }
    }
  }

  public function createChunkPacket($chunk) {
    $x = $chunk->x;
    $z = $chunk->z;

    $blockdata = $chunk->deserialize();

    //  Must flatten data and be zlib deflated
    //  1) Block Types
    //  2) Block Metadata
    //  3) Block Light
    //  4) Sky Light

    $compress = gzcompress($blockdata);

    return new ChunkDataPacket(
      $x,
      0,
      $z,
      $chunk::Width,
      $chunk::Height,
      $chunk::Depth,
      $compress);
  }

  public function enqueuePacket($packet) {
    $this->PacketQueueCount++;
    array_push($this->PacketQueue, $packet);
  }

  public function loadChunk($Coordinates2D) {
    $chunk = $this->World->getFakeChunk($Coordinates2D);
    $this->enqueuePacket(new ChunkPreamblePacket($chunk->x, $chunk->z));
    $this->enqueuePacket($this->createChunkPacket($chunk));

    $serialized = $chunk->x . ":" . $chunk->z;

    $this->loadedChunks[$serialized] = true;
  }

  public function unloadChunk($Coordinates2D) {
    $this->enqueuePacket(new ChunkPreamablePacket($Coordinates2D->x, $Coordiantes2D->z, false));
    $serialized = $chunk->x . ":" . $chunk->z;
    unset($this->loadedChunks[$serialized]);
    $this->loadedChunks = array_values($array);
  }

  public function disconnect() {
    $this->packetQueue = [];
    $this->loadedChunks = [];
    $this->connection->handleClose();
  }

  public function disconnectWithReason($reason) {
    $this->packetQueue = [];
    $this->loadedChunks = [];
    $this->enqueuePacket(new DisconnectPacket($reason));
    $this->connection->handleClose();
  }

}
