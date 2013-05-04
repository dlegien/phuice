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

	use org\legien\phuice\mvc\ViewWrapper;

	/**
	 * An abstract controller that offers handling of views.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	abstract class AbstractController 
	{
		/**
		 * The view.
		 * 
		 * @var ViewWrapper
		 */
		protected $view;

		/**
		 * Initializes the controller.
		 * 
		 * @param ViewWrapper $view The view.
		 */
		public function __construct(ViewWrapper $view) 
		{
			$this->view = $view;
		}

		/**
		 * Renders the view.
		 */
		public function renderView() 
		{
			$this->view->render();
		}

		/**
		 * Returns the view.
		 * 
		 * @return ViewWrapper
		 */
		protected function getView() 
		{
			return $this->view;
		}
		
		/**
		 * Redirects the user to the specified location.
		 * 
		 * @param string $redirect The location of the redirect.
		 */
		protected function redirect($redirect) 
		{
			header("Location: $redirect");
		}
	}
