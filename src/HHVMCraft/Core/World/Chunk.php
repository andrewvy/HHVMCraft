<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\World;

use HHVMCraft\API\Coordinates2D;
use HHVMCraft\Core\Helpers\Hex;

class Chunk {
	const Width = 16;
	const Height = 128;
	const Depth = 16;
	const Size = 32768;

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
		$this->x = $Coordinates2D->x * self::Width;
		$this->z = $Coordinates2D->z * self::Depth;

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

	public function getMetadata($Coordinates3D) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);

		return $this->Metadata[$index];
	}

	public function getSkyLight($Coordinates3D) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);

		return $this->SkyLight[$index];
	}

	public function getBlockLight($Coordinates3D) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);

		return $this->getBlockLight[$index];
	}

	public function setBlockId($Coordinates3D, $val) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
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
		} else if ($oldHeight < $Coordinates3D->y) {
			$this->setHeight($Coordinates3D->x, $Coordinates3D->z, $Coordinates3D->y);
		}
	}


	public function getHeight($x, $z) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));

		return $this->HeightMap[$z * self::Depth + $x];
	}

	public function getBlockID($Coordinates3D) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
		$index = $Coordinates3D->y + ($Coordinates3D->z * self::Height) + ($Coordinates3D->x * self::Height * self::Width);

		return $this->Blocks[$index];
	}

	public function setHeight($x, $z, $val) {
		$this->lastAccessed = new \DateTime(null, new \DateTimeZone('Pacific/Nauru'));
		$this->isModified = true;
		$this->HeightMap[$z * self::Depth + $x] = $val;
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

#		TODO (vy): Actually build chunk deserializer

		try {
			for ($i = 0; $i < self::Size; $i++) {
				$deserialized .= decbin(0x03);
			}

			for ($j = 0; $j < self::Size; $j++) {
				$deserialized .= decbin(0);
			}

			for ($k = 0; $k < self::Size; $k++) {
				$deserialized .= decbin(0);
			}

			for ($l = 0; $l < self::Size; $l++) {
				$deserialized .= decbin(0);
			}
		} catch (Exception $e) {
   			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		return $deserialized;
	}
}
