<?php

namespace HHVMCraft\API;

class BlockRepository {
	public $BlockProviders = [];

	public function __construct() {
		$this->registerBlockProviders();
	}

	public function getBlockProvider($id) {
		return $this->BlockProviders[$id];
	}

	public function registerBlockProviders() {
	//	$this->registerBlockProvider(new GrassBlockProvider());
	}

	public function registerBlockProvider($provider) {
		$this->BlockProviders[$provider->id] = provider;
	}
}
