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

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\IViewWrapper;
	use org\legien\phuice\authentication\WebAuthenticator;

	/**
	 * An abstract controller for websites that takes care of authentication
	 * components.
	 * 
	 * Use this if you want to be able to hide content behind an
	 * authentication of any type.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	abstract class AbstractGatedWebController extends AbstractController 
	{
		/**
		 * The authenticator.
		 * 
		 * @var WebAuthenticator
		 */
		private $_authenticator;

		/**
		 * Initializes an AbstractGatedWebController.
		 * 
		 * @param WebAuthenticator	$authenticator	The authenticator.
		 * @param ViewWrapper		$view			The view.
		 */
		public function __construct(WebAuthenticator $authenticator, IViewWrapper $view) 
		{
			parent::__construct($view);
			$this->setAuthenticator($authenticator);
			$this->getView()->getLayout()->loggedin = $this->isAuthenticated();
		}

		/**
		 * Sets the authenticator.
		 * 
		 * @param WebAuthenticator $authenticator The authenticator.
		 */
		private function setAuthenticator(WebAuthenticator $authenticator) 
		{
			$this->_authenticator = $authenticator;
		}

		/**
		 * Returns the authenticator.
		 * 
		 * @return WebAuthenticator
		 */
		private function getAuthenticator() 
		{
			return $this->_authenticator;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\AbstractController::renderView()
		 */
		public function renderView() 
		{
			if($this->getAuthenticator()->isAuthenticated()) 
			{
				parent::renderView();
			}
			else 
			{
				$this->getAuthenticator()->showAuthentication();
			}
		}

		/**
		 * Returns whether the user is authenticated.
		 * 
		 * @return bool
		 */
		protected function isAuthenticated() 
		{
			return $this->getAuthenticator()->isAuthenticated();
		}
	}
