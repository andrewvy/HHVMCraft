<?php

namespace HHVMCraft\Core\Networking;

function EventReadCallback($bufferEvent, $connection) {
	$cb = $connection->dataCb;
	if(!$cb)
		return;

	$dataArray = array();
	while($data = event_buffer_read($bufferEvent,256)) {
		$dataArray[] = $data;
	}

	$cb(implode(NULL, $dataArray));
};

function EventWriteCallback($bufferEvent, $connection) {
	$connection->writePending = FALSE;
	
	if($connection->closePending) {
		$connection->close();
	}
};

function EventErrorCallback($bufferEvent, $events, $connection) {
	$connection->close()
	$cb = $connection->disconnectCb;
	
	if($cb) {
		$cb();
	}
};
