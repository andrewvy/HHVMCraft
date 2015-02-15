<?php

namespace HHVMCraft\API;

class ItemStack {
	public $id;
	public $icount;
	public $metadata;
	public $nbt;

	public function __construct($id, $icount=1, $metadata=0;, $nbt=null;) {
		if ($icount == 0) {
			$this->id = -1;
			$this->metadata = 0;
			$this->nbt = null;
		}

		$this->id = $id;
		$this->icount = $icount;
		$this->metadata = $metadata;
		$this->nbt = $nbt;
	}

	public function emptyStack() {
		return new self(-1);
	}

	public function isEmpty() {
		return ($this->id == -1);
	}

	public function fromStream($StreamWrapper) {
		$slot = self::emptyStack();
		$slot->id = hexdec(bin2hex($StreamWrapper->readUInt16()));
		if ($slot->isEmpty()) {
			return $slot;
		}
		$slot->icount = hexdec(bin2hex($StreamWrapper->readUInt8();
		$slot->metadata = hexdec(bin2hex($StreamWrapper->readUInt16();
		$l = hexdec(bin2hex($StreamWrapper->readUInt16();
		$buf = $StreamWrapper->readUInt8Array($l);
		return $slot;
	}

	public function toStream($StreamWrapper) {
		$str = $StreamWrapper->writeUInt16($this->id);
		if ($this->isEmpty()) {
			return $str;
		}
		
		$str = $str.
			$StreamWrapper->writeUInt8($this->icount).
			$StreamWrapper->writeUInt16($this->metadata);

		if ($this->nbt == null) {
			$str = $str.$StreamWrapper->writeUInt16(-1);
			return $str;
		}

		// Handle NBT compressed data stream -> UInt8 array
	}
	
	public function duplicate() {
		return new self($this->id, $this->icount, $this->metadata, $this->nbt);
	}

	public function canMerge($ItemStack) {
		if ($this->isEmpty() && $ItemStack->isEmpty()) {
			return true;
		} else if ($this->id == $ItemStack->id && $this->metadata == $ItemStack->metadata && $this->nbt == $ItemStack->nbt) {
			return true;	
		} else {
			return false;
		}
	}

	public function equals($ItemStack) {
		if ($this->id == $ItemStack->id && $this->icount == $ItemStack->icount && $this->metadata == $ItemStack->metadata && $this->nbt == $ItemStack->nbt) {
			return true;
		} else {
			return false;
		}
	}
}
