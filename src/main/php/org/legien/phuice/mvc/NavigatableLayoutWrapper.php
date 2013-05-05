<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\LocalizedLayoutWrapper;
	use org\legien\phuice\localization\Translator;
	use org\legien\phuice\navigation\MenuStorage;

	/**
	 * A wrapper for a layout with a menu.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	class NavigatableLayoutWrapper extends LayoutWrapper 
	{
		/**
		 * The storage for menu items.
		 * 
		 * @var MenuStorage
		 */
		private $_menuStorage;

		/**
		 * Initializes the layout.
		 * 
		 * @param Translator	$translator		The translator.
		 * @param string		$filename		The layout filename.
		 * @param MenuStorage	$menuStorage	The storage for menu items.
		 */
		public function __construct($filename, MenuStorage $menuStorage) 
		{
			parent::__construct($filename);
			$this->setMenuStorage($menuStorage);
			$this->buildLayout();
		}

		/**
		 * Sets the menu storage.
		 * 
		 * @param MenuStorage $menuStorage The menu storage.
		 */
		private function setMenuStorage(MenuStorage $menuStorage) 
		{
			$this->_menuStorage = $menuStorage;
		}

		/**
		 * Returns the menu storage.
		 * 
		 * @return MenuStorage
		 */
		private function getMenuStorage() 
		{
			return $this->_menuStorage;
		}

		/**
		 * Builds the layout.
		 */
		private function buildLayout() 
		{
			$this->redirect = $_SERVER['REDIRECT_URL'];

			$this->menu = $this->getMenuStorage()->findAll();
		}
	}