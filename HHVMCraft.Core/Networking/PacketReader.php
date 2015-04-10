<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Helpers/HexDump.php";
require "Packets/KeepAlivePacket.php";
require "Packets/LoginRequestPacket.php";
require "Packets/LoginResponsePacket.php";
require "Packets/HandshakePacket.php";
require "Packets/HandshakeResponsePacket.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\Packets;

// PacketReader
// Does not actually read the packet, the actual packet reading happens in the Client's StreamWrapper.
// This registers all known packets so a packet can be recognized and decoded.
// Wraps the packet enqueuing for clients.

class PacketReader {
	public $protocol_version;
	public $ServerboundPackets = [];
	public $ClientboundPackets = [];

	public function __construct($protocol_version=14) {
		$this->protocol_version = $protocol_version;
	}

	public function registerPackets() {
		// Register new packet type. type: packet, serverbound: bool, clientbound: bool.
		$this->registerPacketType('Packets\KeepAlivePacket', true, false);
		$this->registerPacketType('Packets\LoginRequestPacket', true, false);
		$this->registerPacketType('Packets\LoginResponsePacket', false, true);
		$this->registerPacketType('Packets\HandshakePacket', true, false);
		$this->registerPacketType('Packets\HandshakeResponsePacket', false, true);
//		$this->registerPacketType(Packets\ChatMessagePacket);
		$this->registerPacketType('Packets\TimeUpdatePacket', false, true);
//		$this->registerPacketType(Packets\EntityEquipmentPacket, false, true);
		$this->registerPacketType('Packets\SpawnPositionPacket', true, false);
//		$this->registerPacketType(Packets\UseEntityPacket, true, false);
//		$this->registerPacketType(Packets\UpdateHealthPacket, false, true);
//		$this->registerPacketType(Packets\RespawnPacket);
		$this->registerPacketType('Packets\PlayerGroundedPacket', true, false);
		$this->registerPacketType('Packets\PlayerPositionPacket', true, false);
		$this->registerPacketType('Packets\PlayerLookPacket', true, false);
		$this->registerPacketType('Packets\PlayerPositionAndLookPacket', true, false);
		$this->registerPacketType('Packets\SetPlayerPositionPacket', false, true);
//		$this->registerPacketType(Packets\PlayerDiggingPacket, true, false);
//		$this->registerPacketType(Packets\PlayerBlockPlacementPacket, true, false);
//		$this->registerPacketType(Packets\ChangeHeldItemPacket, true, false);
//		$this->registerPacketType(Packets\UseBedPacket, false, true);
//		$this->registerPacketType(Packets\AnimationPacket);
//		$this->registerPacketType(Packets\PlayerActionPacket, true, false);
		$this->registerPacketType('Packets\SpawnPlayerPacket', false, true);
//		$this->registerPacketType(Packets\SpawnItemPacket, false, true);
//		$this->registerPacketType(Packets\CollectItemPacket, false, true);
//		$this->registerPacketType(Packets\SpawnGenericEntityPacket, false, true);
//		$this->registerPacketType(Packets\SpawnMobPacket, false, true);
//		$this->registerPacketType(Packets\SpawnPaintingPacket, false, true);

//		$this->registerPacketType(Packets\EntityVelocityPacket, false, true);
//		$this->registerPacketType(Packets\DestroyEntityPacket, false, true);
//		$this->registerPacketType(Packets\UselessEntityPacket, false, true);
//		$this->registerPacketType(Packets\EntityRelativeMovePacket, false, true);
//		$this->registerPacketType(Packets\EntityLookPacket, false, true);
//		$this->registerPacketType(Packets\EntityLookAndRelativeMovePacket, false, true);
//		$this->registerPacketType(Packets\EntityTeleportPacket, false, true);

//		$this->registerPacketType(Packets\EntityStatusPacket, false, true);
//		$this->registerPacketType(Packets\AttachEntityPacket, false, true);
//		$this->registerPacketType(Packets\EntityMetadataPacket, false, true);

		$this->registerPacketType('Packets\ChunkPreamblePacket', false, true);
		$this->registerPacketType('Packets\ChunkDataPacket', false, true);
//		$this->registerPacketType(Packets\BulkBlockChangePacket, false, true);
//		$this->registerPacketType(Packets\BlockChangePacket, false, true);
//		$this->registerPacketType(Packets\BlockActionPacket, false, true);

//		$this->registerPacketType(Packets\ExplosionPacket, false, true);
//		$this->registerPacketType(Packets\SoundEffectPacket, false, true);

//		$this->registerPacketType(Packets\EnvironmentStatePacket, false, true);
//		$this->registerPacketType(Packets\LightningPacket, false, true);

//		$this->registerPacketType(Packets\OpenWindowPacket, false, true);
//		$this->registerPacketType(Packets\CloseWindowPacket);
//		$this->registerPacketType(Packets\ClickWindowPacket, true, false);
//		$this->registerPacketType(Packets\SetSlotPacket, false, true);
		$this->registerPacketType('Packets\WindowItemsPacket', false, true);
//		$this->registerPacketType(Packets\UpdateProgressPacket, false, true);
//		$this->registerPacketType(Packets\TransactionStatusPacket, false, true);

//		$this->registerPacketType(Packets\UpdateSignPacket);
//		$this->registerPacketType(Packets\MapDataPacket, false, true);

//		$this->registerPacketType(Packets\UpdateStatisticPacket, false, true);

//		$this->registerPacketType(Packets\DisconnectPacket);

	}

	public function registerPacketType($type, $serverbound=true, $clientbound=true) {
		if ($serverbound) {
			$this->ServerboundPackets[constant('HHVMCraft\Core\Networking\\'.$type.'::id')] = $type;
		}
		if ($clientbound) {
			$this->ClientboundPackets[constant('HHVMCraft\Core\Networking\\'.$type.'::id')] = $type;
		}
	}

	public function readPacket($client, $serverbound=true) {
		$id = $client->streamWrapper->readUInt8();
		if ($serverbound) {
			$type = $this->ServerboundPackets[$id];
		} else {
			$type = $this->ClientboundPackets[$id];
		}

		if ($type == null) {
			echo " >> Unrecognized Packet ID: ".$id."\n";
			return;
		}

		$construct = "HHVMCraft\Core\Networking\\".$type;
		$packet = new ($construct);
		$packet->readPacket($client->streamWrapper);
		return $packet;
	}

	public function writePacket($packet, $client) {
		if ($packet->writePacket($client->streamWrapper) == false) {
			$client->enqueuePacket($packet);
		}
	}
}
