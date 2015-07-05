<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace HHVMCraft\API;

class BlockRepository {
	public $BlockProviders = [];

	public function __construct() {
		$this->registerBlockProviders();
	}

	public function registerBlockProviders() {
//	$this->registerBlockProvider(new GrassBlockProvider());
	}

	public function getBlockProvider($id) {
		return $this->BlockProviders[$id];
	}

	public function registerBlockProvider($provider) {
		$this->BlockProviders[$provider->id] = $provider;
	}
}
