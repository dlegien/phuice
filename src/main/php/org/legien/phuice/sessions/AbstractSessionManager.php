<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\sessions;

	/**
	 * Bundles useful methods for session managers.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	sessions
	 *
	 */
	abstract class AbstractSessionManager
	{
		/**
		 * The timeout as a timestamp.
		 *
		 * @var integer
		 */
		private $_timeout;		
		
		/**
		 * Sets the timeout.
		 *
		 * @param integer $timeout The timeout as a timestamp.
		 */
		public function setTimeout($timeout)
		{
			$this->_timeout = $timeout;
		}
		
		/**
		 * Sets the timeout.
		 * 
		 * @return integer
		 */
		public function getTimeout()
		{
			return $this->_timeout;
		}
		
		/**
		 * Sets the user identification number.
		 * 
		 * @param integer $uid The user identification number.
		 */
		protected function setUid($uid) 
		{
			$_SESSION['uid'] = $uid;
		}
		
		/**
		 * Returns the user identification number.
		 * 
		 * @return integer
		 */
		public function getUid() 
		{
			return isset($_SESSION['uid']) ? $_SESSION['uid'] : NULL;
		}
		
		/**
		 * Sets the language.
		 * 
		 * @param string $language The language.
		 */
		public function setLanguage($language) 
		{
			$_SESSION['language'] = $language;
		}
		
		/**
		 * Returns the language.
		 * 
		 * @return string
		 */
		public function getLanguage() 
		{
			return isset($_SESSION['language']) ? $_SESSION['language'] : NULL;
		}	

		/**
		 * Updates the session timeout.
		 * 
		 * @param integer $newTimeout The new as a timestamp.
		 */
		protected function updateTimeout($newTimeout) 
		{
			$_SESSION['timeout'] = $newTimeout;
		}
		
		/**
		 * Returns whether a valid session exists.
		 * 
		 * @return boolean
		 */
		protected function hasValidSession()
		{
			if(isset($_SESSION['timeout']))
			{
				if($_SESSION['timeout'] > time())
				{
					$this->updateTimeout(time() + $this->_timeout);
					return TRUE;
				}
				$this->destroySession();
			}
			return FALSE;
		}
	}