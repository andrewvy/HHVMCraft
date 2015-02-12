<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;
use HHVMCraft\Core\Networking\Packets;


class PackerReader {
	
	$protocol_version;
	$ServerboundPackets = [];
	$ClientboundPackets = [];

	public function __construct($protocol_version=14) {
		$this->protocol_version = $protocol_version;
	}

	public function registerPackets() {
		// Register new packet type. type: packet, serverbound: bool, clientbound: bool.
		$this->registerPacketType(KeepAlivePacket, true, false);
		$this->registerPacketType(LoginRequestPacket, false, true);
		$this->registerPacketType(LoginResponsePacket, true, false);
		$this->registerPacketType(HandshakePacket, true, false);
		$this->registerPacketType(HandshakeResponsePacket, false, true);
		$this->registerPacketType(ChatMessagePacket);
		$this->registerPacketType(TimeUpdatePacket, false, true);
		$this->registerPacketType(EntityEquipmentPacket, false, true);
		$this->registerPacketType(SpawnPositionPacket, true, false);
		$this->registerPacketType(UseEntityPacket, true, false);
		$this->registerPacketType(UpdateHealthPacket, false, true);
		$this->registerPacketType(RespawnPacket);
		$this->registerPacketType(PlayerGroundedPacket, true, false);
		$this->registerPacketType(PlayerPositionPacket, true, false);
		$this->registerPacketType(PlayerLookPacket, true, false);
		$this->registerPacketType(PlayerPositionAndLookPacket, true, false);
		$this->registerPacketType(SetPlayerPositionPacket, false, true);
		$this->registerPacketType(PlayerDiggingPacket, true, false);
		$this->registerPacketType(PlayerBlockPlacementPacket, true, false);
		$this->registerPacketType(ChangeHeldItemPacket, true, false);
		$this->registerPacketType(UseBedPacket, false, true);
		$this->registerPacketType(AnimationPacket);
		$this->registerPacketType(PlayerActionPacket, true, false);
		$this->registerPacketType(SpawnPlayerPacket, false, true);
		$this->registerPacketType(SpawnItemPacket, false, true);
		$this->registerPacketType(CollectItemPacket, false, true);
		$this->registerPacketType(SpawnGenericEntityPacket, false, true);
		$this->registerPacketType(SpawnMobPacket, false, true);
		$this->registerPacketType(SpawnPaintingPacket, false, true);

		$this->registerPacketType(EntityVelocityPacket, false, true);
		$this->registerPacketType(DestroyEntityPacket, false, true);
		$this->registerPacketType(UselessEntityPacket, false, true);
		$this->registerPacketType(EntityRelativeMovePacket, false, true);
		$this->registerPacketType(EntityLookPacket, false, true);
		$this->registerPacketType(EntityLookAndRelativeMovePacket, false, true);
		$this->registerPacketType(EntityTeleportPacket, false, true);

		$this->registerPacketType(EntityStatusPacket, false, true);
		$this->registerPacketType(AttachEntityPacket, false, true);
		$this->registerPacketType(EntityMetadataPacket, false, true);

		$this->registerPacketType(ChunkPreamblePacket, false, true);
		$this->registerPacketType(ChunkDataPacket, false, true);
		$this->registerPacketType(BulkBlockChangePacket, false, true);
		$this->registerPacketType(BlockChangePacket, false, true);
		$this->registerPacketType(BlockActionPacket, false, true);

		$this->registerPacketType(ExplosionPacket, false, true);
		$this->registerPacketType(SoundEffectPacket, false, true);

		$this->registerPacketType(EnvironmentStatePacket, false, true);
		$this->registerPacketType(LightningPacket, false, true);
			
		$this->registerPacketType(OpenWindowPacket, false, true);
		$this->registerPacketType(CloseWindowPacket);
		$this->registerPacketType(ClickWindowPacket, true, false);
		$this->registerPacketType(SetSlotPacket, false, true);
		$this->registerPacketType(WindowItemsPacket, false, true);
		$this->registerPacketType(UpdateProgressPacket, false, true);
		$this->registerPacketType(TransactionStatusPacket, false, true);

		$this->registerPacketType(UpdateSignPacket);
		$this->registerPacketType(MapDataPacket, false, true);

		$this->registerPacketType(UpdateStatisticPacket, false, true);
	
		$this->registerPacketType(DisconnectPacket);
	}
	
	public function registerPacketType($type, $serverbound=true, $clientbound=true) {
		if ($serverbound) {
			$this->ServerboundPackets[$type::id]);
		}
		if ($clientbound) {
			$this->ClientboundPackets[$type::id]);
		}
	}

}
