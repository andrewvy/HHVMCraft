<?php
/**
* StreamWrapper is part of HHVMCraft - a Minecraft server implemented in PHP
* - The actual dirty bit manipulation.
* - This provides a nice wrapper to read and write packets to/from the stream.
*
* @copyright Andrew Vy 2015
* @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
*/

namespace HHVMCraft\Core\Networking;

use HHVMCraft\Core\Helpers\Hex;

// http://stackoverflow.questions/16039751/php-pack-format-for-signed-32-int-big-endian
define('BIG_ENDIAN', pack('L', 1) === pack('N', 1));

class StreamWrapper {
	public $stream;
	public $streamBuffer;

	public function __construct($stream) {
		$this->stream = $stream;
		$this->streamBuffer = [];
	}

	public function data($data) {
		$arr = array_reverse(str_split(bin2hex($data), 2));

		$this->streamBuffer = array_merge($this->streamBuffer, $arr);
	}

	public function read($len) {
		$s = "";
		for ($i = 0; $i < $len; $i++) {
			$s = $s.hex2bin(array_pop($this->streamBuffer));
		}

		return $s;
	}

	public function readUInt8() {
		return unpack("c", $this->read(1))[1];
	}

	public function writeUInt8($data) {
		return pack("c", $data);
	}

	public function readBool() {
		return (bool) $this->readUInt8();
	}

	public function writeBool($data) {
		if ($data == true) {
			$this->writeUInt8(0x01);
		} else {
			$this->writeUInt8(0x00);
		}
	}

	public function readUInt16() {
		return unpack("n", $this->read(2))[1];
	}

	public function writeUInt16($data) {
		return pack("n*", $data);
	}

	public function readInt() {
		return unpack("N", $this->read(4))[1];
	}

	public function writeInt($data) {
		if (BIG_ENDIAN) {
			return pack('l', $data);
		}

		return strrev(pack("l*", $data));
	}

	public function readLong() {
		return unpack("q", $this->read(8))[1];
	}

	public function writeLong($data) {
		return pack("q*", $data);
	}

	public function readString16() {
		$l = $this->readUInt16();
		$str = "";

		for ($i = 0; $i < $l; $i++) {
			$str = $str . chr($this->readUInt16());
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

	public function readDouble() {
		return unpack("d", $this->read(8))[1];
	}

	public function writeDouble($data) {
		if (BIG_ENDIAN) {
			return pack("d*", $data);
		}

		return strrev(pack("d", $data));
	}

	public function writePacket($data) {
		$res = $this->stream->write($data);
		if ($res != false) {
			return true;
		} else {
			return false;
		}
	}

}
