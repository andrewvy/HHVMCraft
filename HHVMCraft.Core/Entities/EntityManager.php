<?php

namespace HHVMCraft\Core\Entities;

require "HHVMCraft/Core/World/Chunk.php";
use HHVMCraft\Core\World\Chunk;

class EntityManager {
	public $Server;
	public $World;
	public $PhysicsEngine;
	
	public $pending_despawns = [];
	public $entities = [];
	public $nextEntityId = 1;

	public function __construct($Server, $World) {
		$this->Server = $Server;
		$this->PhysicsEngine = new PhysicsEngine($World, $Server->BlockRepository);
		$this->Event = new EventEmitter();

		$this->Event->on("PropertyChanged", function($sender, $propertyName) {
			$this->handlePropertyChanged($sender, $propertyName);	
		});
	}

	public function handlePropertyChanged($entity, $propertyName) {
		if (get_class($entity) == "PlayerEntity") {
			$this->handlePlayerPropertyChanged($propertyName, $entity);
		}
		
		switch ($propertyName) {
			case "Position":
			case "Yaw":
			case "Pitch":
				$this->propegateEntityPositionUpdates($sender);
				break;
			case "Metadata":
				$this->propegateEntityMetadataUpdates($sender);
				break;
		}
	}

	public function handlePlayerPropertyChanged($propertyName, $PlayerEntity) {
		switch ($propertyName) {
			case "Position":
				if ($playerEntity->Position->x >> 4 != $playerEntity->OldPosition->x >> 4 ||
					$playerEntitiy->Position->z >> 4 != $playerEntity->OldPosition->z >> 4) {

					$this->Server->loop->nextTick($client->updateChunks);
					$this->updateClientEntities($entity->client);
				}
				break;
		}	
	}

	public function updateClientEntities($client) {
		$entity = $client->Entity;

		// Remove entities from the client that have moved out of range of the client.
		for ($i=0;$i<count($client->KnownEntities);$i++) {
			$knownEntity = $client->KnownEntities[$i];

			if ($knownEntity->Position->distanceTo($entity->Position) > $client->chunkRadius * Chunk::Depth) {
				$client->enqueuePacket(new DestroyEntityPacket($knownEntity->entityId));
				unset($client->knownEntities[$i]);

				if (get_class($knownEntity) == "PlayerEntity") {
					$c = $knownEntity->Client;

					if (in_array($c->knownEntities, $entity)) {
						unset($c->knownEntities[$entity]);
						array_values($c->knownEntities);

						$c->enqueuePacket(new DestroyEntityPacket($entity->entityId));
					}
				}
			}
		}
		
		// Reindex client entities array after we have removed some elements.
		array_values($client->knownEntities);

		// Now get entities that the client should know about
		$entitiesToSpawn = $this->getEntitiesInRange($entity, $client->chunkRadius);
		foreach($entitiesToSpawn as $e) {
			if ($e != $entity && !in_array($client->knownEntities, $e)) {
				$this->sendEntityToClient($client, $e);

				// If it's a player, make sure that client knows about this entity.
				if (get_class($e == "PlayerEntity")) {
					$c = $e->Client;

					if (!in_array($c->knownEntities, $entity)) {
						$this->sendEntityToClient($c, $entity);
					}
				}
			}
		}
	}

	public function addPlayerEntity($PlayerEntity) {
	
	}
}
