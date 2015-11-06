# Project Setup

`HHVMCraft.API` - Contains all the structs/objects
`HHVMCraft.Core` - Contains core processing classes

# HHVMCraft Server Architecture

Main Server Thread:

BOTTOM LAYER ---- ReactPHP EventLoop
LAYER 1      ---- ReactPHP Socket Server
LAYER 2      ---- MultiplayerServer

CURRENT:

	MultiplayerServer handles both networking + game logic
	on the same eventloop. (Will be split later with pthreads)

	MultiplayerServer handles:
		- Incoming Connections
		- Sends pending Clientbound Packets
		- Runs game loop

CLIENT CONNECTION PROTOCOL:

Handshake packet with client username -->

		<-- Responds with handshake packet specifying authentication method.

LoginRequest packet specifying protocol version and auth details -->

		<-- LoginResponse packet with details about the current world

		PLAYER ENTITY:

		<-- SpawnPosition packet with the client entity spawn position
		<-- SetPlayerPosition packet with the client entity current position

		WORLD TIME:

		<-- TimeUpdate packet with the world's current in-game time

		UPDATE CHUNKS:

		<-- ChunkPreamble packet with details of the incoming chunk data
		<-- ChunkData packet with actual chunk data

Multithreaded scenarios:

	- Logging
	- Client Packet Receiver (Enqueues packets to be processed onto the main thread)
	- Client Packet Transmit (Dequeues packets to be emitted to the client)
	- World Chunk IO (Loads chunks from disk/memory)
	- Physics Engine (maybe?)

CLIENT PACKET HANDLER
---------------------

	Each client has their own packet processing thread which handles
	incoming packets before enqueuing it onto the main process thread.

	CLIENT 1:				CLIENT 2:				CLIENT 3:
	---------------------------------------------------------

	PACKET X				PACKET Y				PACKET Z
	.						.						.
	.						.						.
	.						.						.
	.						.						.
	DONE					.						DONE
	PACKET A				.
	.						.
	.						.
	DONE					DONE

	PACKET X + Z finished at the same time BUT Client 1 obtained the mutex first, and then Client 3 obtained it second.
	PACKET Y + A finished at the same time BUT Client 1 obtained the mutex first, and then Client 2 obtained it second.

	Server Packet Processing Queue (threadsafe LIFO stack):
	--------------------------------------

	1) PACKET X - Client 1
	2) PACKET Z - Client 2
	3) PACKET A - Client 1
	4) PACKET Y - Client 3

ENTITIY MANAGER
-----------------

EM holds the UUID -> entity relationship
Clients holds the array of UUIDs that the client "knows" about.


When an entity updates the position, we need to check if the entity has moved out of range of any clients.
Calculate range by checking the 3D coordinates of the Entity
If an entity is out of range:
	Remove it from the array of known entities from that client
	And if the entity is a PlayerEntity, also remove the client from the moved entity's client
