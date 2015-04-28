<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Windows;

use HHVMCraft\Core\Windows\WindowArea;
use HHVMCraft\API\ItemStack;

class CraftingWindowArea extends WindowArea {
	const craftingOutput = 0;
	public $CraftingRepository;

	public function __construct($CraftingRepository, $startIndex, $width=2, $height=2) {
		parent::__construct($startIndex, $width * $height + 1, $width, $height);

//		$this->CraftingRepository = $CraftingRepository;
		$this->Event->on("WindowChange", function($index, $value) {
			$this->handleWindowChange($index, $value);
		});
	}

	public function handleWindowChange($index, $value) {
		$current = $CraftingRepository->getRecipe($this->Bench());

		if ($index == self::craftingOutput) {
			if (empty($value) && $current != null) {
				$this->removeItemFromOutput($current);

				$current = $CraftingRepository->getRecipe($this->Bench());
			}
		}

		if ($current == null) {
			$this->Items[self::craftingOutput] = ItemStack::emptyStack();
		} else {
			$this->Items[self::craftingOutput] = $current->output();
		}
	}

	public function removeItemFromOutput($Recipe) {
		$x = 0;
		$y = 0;

		for ($x=0;$x<$this->width;$x++) {
			$found = false;
			for ($y=0;$y<$this->height;$y++) {
				if ($CraftingRepository->testRecipe($this->Bench(), $Recipe, $x, $y)) {
					$found = true;
					break;
				}
			}

			if ($found == true) {
				break;
			}
		}

		for ($_x=0;$_x < $Recipe->Pattern->getLength(1);$_x++) {
			for ($_y=0;$_y < $Recipe->Pattern->getLength(0);$_y++) {
				$item = $this->Items[($y+$_y) * $this->width + ($x + $_x) + 1];
				$item->icount -= $Recipe->Pattern->icount;
				$this->Items[($y+$_y) * $this->width + ($x + $_x) + 1] = $item;
			}
		}
	}

	public function Bench() {
		$result = new WindowArea(1, $this->width * $this->height, $this->width, $this->height);
		for ($i=1;$i<$this->Items->length;$i++) {
			$result->Items[$i-1] = $this->Items[$i];
		}

		return $result;
	}
}
