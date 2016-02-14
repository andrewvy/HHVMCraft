<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\Core\Windows;

use Evenement\EventEmitter;
use HHVMCraft\API\ItemStack;


class Window {
	public $Windows;
	public $Event;
	public $WindowAreas = [];

	public function __construct() {
		$this->Event = new EventEmitter();
	}

	public function moveToAlternateArea($index) {
		$fromIndex = $this->getAreaIndex($index);
		$from = $this->getArea($index);
		$slot = $this->from[$index];

		if ($slot == null) {
			return;
		}

		$to = $this->getLinkedArea($fromIndex, $slot);
		$destination = $to->moveOrMergeItem($index, $slot, $from);
		$this->windowChange($destination + $to->startIndex, $slot);
	}

	public function getAreaIndex($index) {
		for ($i = 0; $i < count($this->WindowAreas); $i++) {
			$Area = $this->WindowAreas[$i];
			if ($index >= $Area->startIndex && $index < $Area->startIndex + $Area->length) {
				return $i;
			}
		}
	}

	// Get the window area responsible for this index, and modify index accordingly.

	public function getArea(&$index) {
		foreach ($WindowAreas as $Area) {
			if ($Area->startIndex <= $index && $Area->startIndex + $Area->length > $index) {
				$index = $index - $Area->startIndex;
				return $Area;
			}
		}
	}

	// Gets window area index from index

	public function windowChange() {
		$this->Event->emit("WindowChange", (func_get_args()));
	}

	public function length() {
		$this->windowAreaLength();
	}

	public function windowAreaLength() {
		$l = 0;
		foreach ($this->WindowAreas as $Area) {
			$l = $l + $Area->length;
		}

		return $l;
	}

	public function isEmpty() {
		$hasStuff = false;

		foreach ($WindowAreas as $Area) {
			foreach ($Area->Items as $Item) {
				if (!empty($Item)) {
					$hasStuff = true;
				}
			}
		}

		return !$hasStuff;
	}

	public function getSlots() {
		$l = $this->windowAreaLength();
		$slots = array_fill(0, $l, 0);

		for ($i = 0; $i < $l; $i++) {
			$slots[$i] = ItemStack::emptyStack();
		}

		foreach ($this->WindowAreas as $Area) {
			for ($i = 0; $i < $Area->length; $i++) {
				$index = $Area->startIndex + $i;
				$slots[$index] = $Area->Items[$i];
			}
		}

		return $slots;
	}

}
