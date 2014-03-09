<?php

	namespace org\legien\phuice;
	
	class GuidGenerator
	{
		public static function createGuid($namespace = '') 
		{
			$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
			$localAddress = isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : '127.0.0.1';
			$localPort = isset($_SERVER['LOCAL_PORT']) ? $_SERVER['LOCAL_PORT'] : 80;
			$remoteAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
			$remotePort = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 8080;
			
			static $guid = '';
			$uid = uniqid("", true);
			$data = $namespace;
			$data .= $_SERVER['REQUEST_TIME'];
			$data .= $userAgent;
			$data .= $localAddress;
			$data .= $localPort;
			$data .= $remoteAddress;
			$data .= $remotePort;
			$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
			$guid = '{' .
					substr($hash,  0,  8) .
					'-' .
					substr($hash,  8,  4) .
					'-' .
					substr($hash, 12,  4) .
					'-' .
					substr($hash, 16,  4) .
					'-' .
					substr($hash, 20, 12) .
					'}';
			return $guid;
		}
	}