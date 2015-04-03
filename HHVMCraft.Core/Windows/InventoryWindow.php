<?php

namespace HHVMCraft\Core\Windows;

require "Window.php";
require "CraftingWindowArea.php";
require "ArmorWindowArea.php";

use HHVMCraft\Core\Windows\Window;
use HHVMCraft\Core\Windows\CraftingWindowArea;
use HHVMCraft\Core\Windows\ArmorWindowArea;

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
		} else {
			return $this->WindowAreas[3];
		}
	}

	// TODO
	public function pickUpStack() {

	}

	// TODO
	public function copyToInventory() {

	}
}
