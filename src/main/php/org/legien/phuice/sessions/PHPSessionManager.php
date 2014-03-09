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
	
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\sessions\AbstractSessionManager;

	/**
	 * A manager for basic PHP session.
	 * 
	 * @author 		Daniel Legien
	 * @package 	org.legien.phuice
	 * @subpackage	sessions
	 */
	class PHPSessionManager extends AbstractSessionManager implements SessionManager 
	{
		public function __construct($timeout) {
			if(!isset($_SESSION)) {
				@session_start();
			}
			$this->setTimeout($timeout);
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\sessions\SessionManager::hasActiveSession()
		 */
		public function hasActiveSession() {
			if(isset($_SESSION['uid'])) {
				return $this->hasValidSession();
			}
			return FALSE;
		}

		public function destroySession() 
		{
			if(isset($_SESSION)) 
			{
				@session_start();
				session_destroy();
			}
		}

		public function startSession($uid, $sessid, $timestamp) {
			//## uncomment the following lines to make the "one person at a time is logged in" working ##
			if($sessid) {
				session_id($sessid);
				@session_start();
				session_destroy();	
			}
			@session_start();
			//## uncomment the following line to make the "one person at a time is logged in" working ##
			session_regenerate_id(true);
			$this->setUid($uid);
			$this->updateTimeout($timestamp + $this->getTimeout());

			return session_id();
		}
	}
