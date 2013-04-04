<?php

	namespace org\legien\phuice\installation;
	
	interface InstallerStrategy
	{		
		public function invokeInstall();
		public function invokeUpdate();
		public function invokeDowngrade();
	}
