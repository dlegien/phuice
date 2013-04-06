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

	namespace org\legien\phuice\authentication;

	use org\legien\phuice\authentication\Authenticator;

	/**
	 * An authenticator that can be used in websites as opposed to an
	 * authenticator that can be used from the commandline.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	authentication
	 */
	interface WebAuthenticator extends Authenticator 
	{
		/**
		 * Shows the authentication form of the authenticator.
		 */
		public function showAuthentication();

		/**
		 * Verifies the given password input with the given hash.
		 * 
		 * @param	string	$hash	The hash to check against.
		 * @param	string	$input	The user input password.
		 * 
		 * @return	boolean
		 */
		public function verifyPassword($hash, $input);
	}
