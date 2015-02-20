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
		$this->x = floatval($StreamWrapper->readDouble());
		$this->y = floatval($StreamWrapper->readDouble());
		$this->stance = floatval($StreamWrapper->readDouble());
		$this->z = floatval($StreamWrapper->readDouble());
		$this->yaw = floatval($StreamWrapper->readInt());
		$this->pitch = floatval($StreamWrapper->readInt());
		$this->onGround = $StreamWrapper->readBool();
		Hex::dump($this->yaw);
		//		echo " Position: <".$this->x.",".$this->y.",".$this->z."> Yaw: ".$this->yaw." , Pitch: ".$this->pitch."\n";
	}
}
