<?php

	namespace org\legien\phuice\sessions;
	
	use org\legien\phuice\testing\AbstractMock;
	
	class SessionManagerMock extends AbstractMock implements SessionManager
	{
		/**
		 * Returns whether an active session exists.
		 *
		 * @return boolean
		 */
		public function hasActiveSession()
		{
			$this->registerCall('SessionManagerMock', 'hasActiveSession', array());
		}
		
		/**
		 * Sets the language of the session.
		 *
		 * @param string $language The language.
		*/
		public function setLanguage($language)
		{
			$this->registerCall('SessionManagerMock', 'setLanguage', array($language));
		}
		
		/**
		 * Returns the language of the session.
		 *
		 * @return string
		*/
		public function getLanguage()
		{
			$this->registerCall('SessionManagerMock', 'getLanguage', array());
		}
		
		/**
		 * Returns the user identification
		 *
		 * @return mixed
		*/
		public function getUid()
		{
			$this->registerCall('SessionManagerMock', 'getUid', array());
		}		
	}