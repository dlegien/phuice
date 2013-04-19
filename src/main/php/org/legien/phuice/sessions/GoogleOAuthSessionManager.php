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
	 * A session manager for Google OAuth authentications. Makes use
	 * of the Google OAuth API.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	sessions
	 */
	class GoogleOAuthSessionManager extends AbstractSessionManager implements SessionManager
	{
		/**
		 * Creates a new instance.
		 * 
		 * @param integer $timeout The timeout as a timestamp.
		 */
		public function __construct($timeout)
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			$this->setTimeout($timeout);
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\sessions\SessionManager::hasActiveSession()
		 */
		public function hasActiveSession()
		{
			if(isset($_SESSION['token']))
			{
				return $this->hasValidSession();
			}
			return FALSE;
		}

		/**
		 * Destroys the session by revoking the token and destorying
		 * the php session.
		 */
		public function destroySession()
		{
			try 
			{
				require_once 'googleapi/Google_Client.php';
				require_once 'googleapi/contrib/Google_Oauth2Service.php';

				$client = new \Google_Client();
				$client->setApplicationName("Google UserInfo PHP Starter Application");			
			
				if (isset($_SESSION['token'])) 
				{
					$client->setAccessToken($_SESSION['token']);
				}			
				$client->revokeToken();
			}
			catch(\Exception $e)
			{
				// Invalid token
			}
					
			if(isset($_SESSION))
			{
				@session_start();
				session_destroy();
			}
		}
		
		/**
		 * Sets the token.
		 * 
		 * @param string $token The token.
		 */
		private function setToken($token)
		{
			$_SESSION['token'] = $token;
		}

		/**
		 * Starts a session.
		 * 
		 * @param array $tokens An array with the uid and the token.
		 * @param integer $timestamp The timestamp.
		 */
		public function startSession($tokens, $timestamp) 
		{	
			list($uid, $token) = $tokens;			
			@session_start();
			$this->setUid($uid);
			$this->setToken($token);
			$this->updateTimeout($timestamp + $this->getTimeout());
		}
	}
