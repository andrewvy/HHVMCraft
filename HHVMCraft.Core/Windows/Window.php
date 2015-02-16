<?php

namespace HHVMCraft\Core\Windows;

require "HHVMCraft.API/ItemStack.php";
require "vendor/autoload.php";

use HHVMCraft\API\ItemStack;
use Evenement\EventEmitter;


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

	public function windowChange() {
		$this->Event->emit("WindowChange", (func_get_args()));
	}

	// Get the window area responsible for this index, and modify index accordingly.
	public function getArea(&$index) {
		foreach($WindowAreas as $Area) {
			if ($Area->startIndex <= $index && $Area->startIndex + $Area->length > $index) {
				$index = $index - $Area->startIndex;
				return $Area;	
			}
		}
	}

	// Gets window area index from index
	public function getAreaIndex($index) {
		for($i=0;$i<count($this->WindowAreas);$i++) {
			$Area = $this->WindowAreas[$i];
			if ($index >= $Area->startIndex	&& $index < $Area->startIndex + $Area->length) {
				return $i;
			}
		}	
	}

	public function length() {
		$this->windowAreaLength();
	}

	public function isEmpty() {
		$hasStuff = false;

		foreach($WindowAreas as $Area) {
			foreach($Area->Items as $Item) {
				if (!empty($Item)) {
					$hasStuff = true; 
				}	
			}
		}
		
		return !$hasStuff;
	}

	public function windowAreaLength() {
		$l = 0;
		foreach($this->WindowAreas as $Area) {
			$l = $l + $Area->length;
		}
		return $l;
	}

	public function getSlots() {
		$l = $this->windowAreaLength();
		$slots = new ItemSlot[$l];

		// TODO: Need to create new itemslots with all of the itemslots of the windowareas.
		foreach($this->WindowAreas as $Area) {	
			for($i=0;$i<$Area->length;$i++) {
				$index = $Area->startIndex + $i;
				$slots[$index] = $Area->Items[$i];
			}
		}

		return $slots;
	}
}
