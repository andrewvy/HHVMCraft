<?php

namespace HHVMCraft\Core\World;

require "HHVMCraft.API/Coordinates2D.php";
require "NBTProvider.php";

use HHVMCraft\API\Coordinates2D;
use HHVMCraft\Core\World\NBT;

class Chunk {
	const Width = 16;
	const Height = 128;
	const Depth = 16;
	const Size = 16 * 16 * 128;

	public $isModified;
	public $lastAccessed;
	public $Blocks = [];
	public $Metadata = [];
	public $BlockLight = [];
	public $SkyLight = [];
	public $Biomes = [];
	public $HeightMap = [];

	public $x;
	public $z;

	public function __construct($Coordinates2D) {
		$this->x = $Coordinates2D->x;
		$this->z = $Coordinates2D->z;

		$this->Blocks = array_fill(0, self::Size, 0x00);
		$this->Metadata = array_fill(0, self::Size, 0x00);
		$this->BlockLight = array_fill(0, self::Size, 0x00);
		$this->HeightMap = array_fill(0, self::Size, 0x00);
		$this->SkyLight = array_fill(0, self::Size, 0xFF);
	}

	public function Coordinates() {
		return new Coordinates2D($this->x, $this->z);
	}

	public function setCoordinates($Coordinates2D) {
		$this->x = $Coordinates2D->x;
		$this->z = $Coordinates2D->z;
	}

	public function getBlockID($Coordinates3D) {
		$this->lastAccessed = new \DateTime();
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);
		return $this->Blocks[$index];
	}

	public function getMetadata($Coordinates3D) {
		$this->lastAccessed = new \DateTime();
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);
		return $this->Metadata[$index];
	}

	public function getSkyLight($Coordinates3D) {
		$this->lastAccessed = new \DateTime();
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);
		return $this->SkyLight[$index];
	}

	public function getBlockLight($Coordinates3D) {
		$this->lastAccessed = new \DateTime();
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);
		return $this->getBlockLight[$index];
	}

	public function getHeight($x, $z) {
		$this->lastAccessed = new \DateTime();
		return $this->HeightMap[$z * self::Depth + $x];
	}

	public function setHeight($x, $z, $val) {
		$this->lastAccessed = new \DateTime();
		$this->isModified = true;
		$this->HeightMap[$z * self::Depth + $x] = $val;
	}

	public function setBlockId($Coordinates3D, $val) {
		$this->lastAccessed = new \DateTime();
		$this->isModified = true;
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);
		$this->Blocks[$index] = $val;

		$oldHeight = $this->getHeight($Coordinates3D->x, $Coordinates3D->z);
		if ($val == 0x00) {
			if ($oldHeight < $Coordinates3D->y) {
				while ($Coordinates3D->y > 0) {
					$Coordinates3D->y--;
					if ($this->getBlockId($Coordinates3D) != 0x00) {
						$this->setHeight($Coordinates3D->x, $Coordinates3D->z, $Coordinates3D->y);
					}
				}
			}
		}
		else {
			if ($oldHeight < $Coordinates3D->y) {
				$this->setHeight($Coordinates3D->x, $Coordinates3D->z, $Coordinates3D->y);
			}
		}
	}

	public function toNbt() {
	}

	public function fromNbt($NbtFile) {
	}

	public function nbtSerialize($TagName) {
	}

	public function nbtDeserialize($val) {
	}

	public function deserialize() {
		$deserialized = "";
		$blockLength = Self::Size * 4;
		$blockData = [];
		array_push($blockData, $this->Blocks, $this->Metadata, $this->BlockLight, $this->SkyLight);

		for	($i=0; $i<$blockLength; $i++) {
			$deserialized .= pack("H*", $blockData[$i]);
		}

		return $deserialized;
	}
}
