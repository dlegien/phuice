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
	 * A manager that handles the creation, storing and deletion of sessions.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	sessions
	 *
	 */
	interface SessionManager 
	{
		/**
		 * Returns whether an active session exists.
		 * 
		 * @return boolean
		 */
		public function hasActiveSession();
		
		/**
		 * Sets the language of the session.
		 * 
		 * @param string $language The language.
		 */
		public function setLanguage($language);
		
		/**
		 * Returns the language of the session.
		 * 
		 * @return string
		 */
		public function getLanguage();
		
		/**
		 * Returns the user identification
		 * 
		 * @return mixed
		 */
		public function getUid();
	}
