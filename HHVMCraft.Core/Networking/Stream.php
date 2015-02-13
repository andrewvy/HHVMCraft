<?php

namespace HHVMCraft\Core\Networking;

require "HHVMCraft.Core/Helpers/HexDump.php";

use HHVMCraft\Core\Helpers\Hex;

class StreamWrapper {
	public $stream;
	public $streamBuffer = [];

	public function __construct($stream) {
		$this->stream = $stream;
	}

	public function data($data) {
		$this->streamBuffer = $this->streamBuffer + str_split(bin2hex($data), 2);
	}

	public function handleClose() {
		$this->stream->handleClose();
	}

	// UINT8: 0x00

	public function readUInt8() {	
		$b = array_shift($this->streamBuffer);
		if ($b) {
			return $b;
		} else {
			throw new \Exception("Malformed packet, buffer is empty");
		}
	}

	public function writeUInt8($data) {
		return pack("c*", $data);
	}

	// UINT16: 0x0000

	public function readUInt16() {
		return pack("H*",$this->readUInt8().$this->readUInt8());
	}

	public function writeUInt16($data) {
		return pack("s*", $data);
	}

	// INT: 0x0000 0x0000
	
	public function readInt() {
		return pack("H*",$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8());
	}

	public function writeInt($data) {
		return pack("l*", $data);
	}

	// LONG: 0x0000 0x0000 0x0000 0x0000
	
	public function readLong() {
		return pack("H*",$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8());
	}

	public function writeLong($data) {
		return pack("q*",$data);
	}

	// STRING16: 0x0000 0x0000...
	// UCS-2 encoding, big endian, U+0000 U+0000 ....

	public function readString16() {
		$l = (int) $this->readUInt16();
		$str = "";

		for	($i=0; $i<6; $i++) {
			$str = $str.$this->readUInt16();
		}
		
		if (strlen($str) > 0) {
			return $str;
		} else {
			throw new \Exception("Malformed string, was empty");
		}
	}

	public function writeString16($str) {
		$str = iconv("UTF-8", "UTF-16", $str);
		$a = str_split($str, 1);
		$str = unpack('N', $a);
		
		return pack("ch*", strlen($str), $str);
	}

	public function writePacket($packet) {
		$this->stream->socket_write($packet->data);
	}
}
