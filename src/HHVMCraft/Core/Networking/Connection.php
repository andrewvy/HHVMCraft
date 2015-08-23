<?php
/**
 * Connection is part of HHVMCraft - a Minecraft server implemented in PHP
 * - Extended off React's Stream
 * - Handles new packets incoming, and stores them in the client's packet buffer.
 * - Also handles cleanly closing the socket.
 *
 * @copyright Andrew Vy 2015
 * @license MIT <https://github.com/andrewvy/HHVMCraft/blob/master/LICENSE.md>
 */
namespace React\Socket;

use React\Stream\Stream;

class Connection extends Stream implements ConnectionInterface {
	public function handleData($stream) {
		$data = stream_socket_recvfrom($stream, $this->bufferSize);
		if ('' !== $data && false !== $data) {
			$this->emit('data', array($data, $this));
		}

		if ('' === $data || false === $data || !is_resource($stream) || feof($stream)) {
			$this->end();
		}
	}

	public function handleClose() {
		if (is_resource($this->stream)) {
			// http://chat.stackoverflow.com/transcript/message/7727858#7727858
			stream_socket_shutdown($this->stream, STREAM_SHUT_RDWR);
			stream_set_blocking($this->stream, false);
			fclose($this->stream);
		}
	}

	public function getRemoteAddress() {
		return $this->parseAddress(stream_socket_get_name($this->stream, true));
	}

	private function parseAddress($address) {
		return trim(substr($address, 0, strrpos($address, ':')), '[]');
	}
}
