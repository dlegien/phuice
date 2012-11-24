<?php
	
	namespace org\legien\phuice\sessions;

	interface SessionManager {

		public function hasActiveSession();
		
		public function setLanguage($language);
		
		public function getLanguage();
		
		public function getUid();

	}
