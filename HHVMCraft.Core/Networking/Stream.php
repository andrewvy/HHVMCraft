<?php

namespace HHVMCraft\Core\Networking;

class StreamWrapper {
	public $stream;
	public $buffer;
	public $offset;

	public function __construct($stream) {
	}

	public function data($data) {
	}

	public function handleClose() {
		$this->physicalStream->handleClose();
	}

	// UINT8: 0x00

	public function readUInt8() {	
		$this->offset = offset + 2;
	}

	public function writeUInt8() {
	
	}

	// UINT16: 0x0000

	public function readUInt16() {
		
	}

	public function writeUInt16() {
	
	}

	// INT: 0x0000 0x0000
	
	public function readInt() {
	
	}

	public function writeInt() {
	
	}

	// LONG: 0x0000 0x0000 0x0000 0x0000
	
	public function readLong() {
	
	}

	public function writeLong()  {
	
	}

	// STRING16: 0x0000 0x0000...
	// UCS-2 encoding, big endian, U+0000 U+0000 ....

	public function readString16($length) {
		
	}

	public function writeString16($length) {

	}

	public function writePacket($packet) {
		$this->physicalStream->socket_write($packet->data);
	}
}
