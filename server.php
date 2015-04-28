<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
error_reporting(E_ERROR);

require "vendor/autoload.php";

use HHVMCraft\Core\Networking\MultiplayerServer;

$addr = "127.0.0.01";

$server = new MultiplayerServer($addr);

$server->start(25565);
