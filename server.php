<?php
/**
 * This file is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 * // */

date_default_timezone_set('UTC');

require "vendor/autoload.php";

use HHVMCraft\Core\Networking\MultiplayerServer;
error_reporting(E_ALL);

$addr = "127.0.0.1";

$server = new MultiplayerServer($addr);
$server->start(25565);
