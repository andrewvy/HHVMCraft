<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\API;

class BlockProvider {

	public $MaxStack = 64;
	public $BlastResistance = 0;
	public $Hardness = 0;
	public $Luminance = 0;
	public $Opaque = true;
	public $LightModifier = 1;

	public function onLeftClicked($BlockDescriptor, $BlockFace, $World, $Client) {
	}

	public function onRightClicked($BlockDescriptor, $BlockFace, $World, $Client) {
	}

	public function onMined($BlockDescriptor, $BlockFace, $World, $Client) {
		$this->generateDropEntity($BlockDescriptor, $World, $Client->server);
		$World->setBlockId($BlockDescriptor->Coordinates, 0x00);
	}

	public function generateDropEntity($BlockDescriptor, $World, $Server) {
		$EntityManager = $Server->EntityManager;

		// For each item drop, do this
		//     ItemEntity = new ItemEntity($Coordinates3D, $Item);
		//     EntityManager->SpawnEntity(ItemEntity);
	}

	public function onItemUsed($Coordinates3D, $ItemStack, $BlockFace, $World) {
	}
}
