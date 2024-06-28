<?php

namespace BomberNet\Sockets;

use Socket;

class Sockets
	{
		public static function connectIP (string $host,int $port):Socket
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
		
		public static function listenIP (int $port,bool $block=false,string $host='0.0.0.0',bool $reuse=false):Socket
			{
				$socket=socket_create (AF_INET,SOCK_STREAM,SOL_TCP);
				if ($reuse)
					{
						socket_set_option ($socket,SOL_SOCKET,SO_REUSEADDR,1);
						socket_set_option ($socket,SOL_SOCKET,SO_REUSEPORT,1);
					}
				$mode=$block?'socket_set_block':'socket_set_nonblock';
				$mode ($socket);
				socket_bind ($socket,$host,$port);
				socket_listen ($socket);
				return $socket;
			}
		
		public static function listenUNIX (string $socketFile,bool $block=true):Socket
			{
				if (file_exists ($socketFile)) unlink ($socketFile);
				$socket=socket_create (AF_UNIX,SOCK_STREAM,0);
				$mode=$block?'socket_set_block':'socket_set_nonblock';
				$mode ($socket);
				socket_bind ($socket,$socketFile);
				socket_listen ($socket);
				return $socket;
			}
	}
