<?php

namespace BomberNet\Sockets;

use Socket;

class Sockets
	{
		public static function listenUNIX (string $socketFile,bool $blocked=false):Socket
			{
				if (file_exists ($socketFile)) unlink ($socketFile);
				$socket=socket_create (AF_UNIX,SOCK_STREAM,0);
				$mode=$blocked?'socket_set_block':'socket_set_nonblock';
				$mode ($socket);
				socket_bind ($socket,$socketFile);
				socket_listen ($socket);
				return $socket;
			}
		
		public static function connectTCP (string $host,int $port):Socket
			{
				$socket=socket_create (AF_INET,SOCK_STREAM,SOL_TCP);
				socket_connect ($socket,$host,$port);
				return $socket;
			}
		
		public static function connectUNIX (string $socketFile):Socket
			{
				$socket=socket_create (AF_UNIX,SOCK_STREAM,0);
				socket_connect ($socket,$socketFile);
				return $socket;
			}
	}
