<?php

namespace HHVMCraft\Core\Networking\Packets;

require "HHVMCraft.Core/Helpers/HexDump.php";
use HHVMCraft\Core\Helpers\Hex;

class PlayerPositionAndLookPacket {
	const id = "0d";

	public $x;
	public $y;
	public $stance;
	public $z;
	public $yaw;
	public $pitch;
	public $onGround;

	public function readPacket($StreamWrapper) {
		$StreamWrapper->readDouble();
		$this->y = $StreamWrapper->readDouble();
		$this->stance = $StreamWrapper->readDouble();
		$this->z = $StreamWrapper->readDouble();
		$this->yaw = $StreamWrapper->readInt();
		$this->pitch = $StreamWrapper->readInt();
		$this->onGround = $StreamWrapper->readBool();
		//		echo " Position: <".$this->x.",".$this->y.",".$this->z."> Yaw: ".$this->yaw." , Pitch: ".$this->pitch."\n";
	}
}
