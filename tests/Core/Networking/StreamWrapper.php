<?php
/**
 * StreamWrapper is part of HHVMCraft - a Minecraft server implemented in PHP
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */

require "vendor/autoload.php";

use HHVMCraft\Core\Networking\StreamWrapper;

class StreamWrapperTest extends PHPUnit_Framework_TestCase {

  public function testCanReceiveData() {
    $StreamWrapper = new StreamWrapper();
  }
}
