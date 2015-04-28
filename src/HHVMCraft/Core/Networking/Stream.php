<?php

namespace HHVMCraft\Core\Networking;

use HHVMCraft\Core\Helpers\Hex;

// http://stackoverflow.questions/16039751/php-pack-format-for-signed-32-int-big-endian

define('BIG_ENDIAN', pack('L', 1) === pack('N', 1));

// StreamWrapper
// The actual dirty bit manipulation.
// This provides a nice wrapper to read and write packets to/from the stream.

class StreamWrapper {
	public $stream;
	public $streamBuffer = [];

	public function __construct($stream) {
		$this->stream = $stream;
	}

	public function data($data) {
		$this->streamBuffer = $this->streamBuffer + str_split(bin2hex($data), 2);
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
		return pack("H*", $data);
	}

	public function readBool() {
		$bool = $this->readUInt8();
		return (bool) $bool;
	}

	public function writeBool($data) {
		if ($data == true) {
			$this->writeUInt8(0x01);
		} else {
			$this->writeUInt8(0x00);
		}
	}

	// UINT16: 0x0000

	public function readUInt16() {
		return pack("H*",$this->readUInt8().$this->readUInt8());
	}

	public function writeUInt16($data) {
		return pack("n*", $data);
	}

	// INT: 0x0000 0x0000

	public function readInt() {
		return pack("H*",$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8());
	}

	public function writeInt($data) {
		if (BIG_ENDIAN) {
			return pack('l', $data);
		}

		return strrev(pack("l*", $data));
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
		$l = hexdec(bin2hex($this->readUInt16()));
		$str = "";

		for	($i=0; $i<$l; $i++) {
			$str = $str.$this->readUInt16();
		}

		if (strlen($str) > 0) {
			return $str;
		} else {
			// No string found?
		}
	}

	public function writeString16($str) {
		$str = iconv("UTF-8", "UTF-16BE", $str);
		return $str;
	}

	public function readUInt8Array($length) {
		$array = [];
		for ($i=0;$i<$length;$i++) {
			array_push($array, $this->readUInt8());
		}
		return $array;
	}

	public function readDouble() {
		return pack("H*",$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8().$this->readUInt8());
	}

	public function writeDouble($data) {
		if (BIG_ENDIAN) {
			return pack("d*", $data);
		}

		return strrev(pack("d", $data));
	}

	public function writeUInt8Array($array) {
		return pack("H*", $array);
	}

	public function writePacket($data) {
		$res = socket_write($this->stream, $data);
		if ($res != false) {
			return true;
		} else {
			return false;
		}
	}

}
