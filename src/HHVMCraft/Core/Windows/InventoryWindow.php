<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Windows;

class InventoryWindow extends Window {
	const name = "Inventory";
	const craftingOutputIndex = 0;
	const hotbarIndex = 36;
	const craftingGridIndex = 1;
	const armorIndex = 5;
	const mainIndex = 9;

	// InventoryWindow does not have window type.
	const type = -1;

	public function __construct($CraftingRepository) {
		parent::__construct();

		$this->WindowAreas = [
		new CraftingWindowArea($CraftingRepository, self::craftingOutputIndex),
		new ArmorWindowArea(self::armorIndex),
		new WindowArea(self::mainIndex, 27, 9, 3),
		new WindowArea(self::hotbarIndex, 9, 9, 1)
		];
	}

	public function getLinkedArea($index, $slot) {
		if ($index == 0 || $index == 1 || $index == 3) {
			return $this->WindowAreas[2];
		}
		else {
			return $this->WindowAreas[3];
		}
	}

	// TODO (vy)
	public function pickUpStack() {

	}

	// TODO (vy)
	public function copyToInventory() {

	}
}
