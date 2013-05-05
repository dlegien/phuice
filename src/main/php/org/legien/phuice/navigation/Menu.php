<?php

	namespace org\legien\phuice\navigation;

	use org\legien\phuice\mvc\Model;

	/**
	 * An entity that describes a menu entry.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	navigation
	 *
	 */
	class Menu implements Model 
	{
		/**
		 * The display name of the menu entry.
		 * 
		 * @var string
		 */
		private $name;
		
		/**
		 * The url associated with the menu entry.
		 * 
		 * @var string
		 */
		private $url;
		
		/**
		 * The access right required to see the menu entry.
		 * 
		 * @var integer
		 */
		private $requiredAccess;
		
		/**
		 * Whether the menu entry can only be seen after a login.
		 * 
		 * @var boolean
		 */
		private $requiresLogin;

		/**
		 * Sets the name of the menu entry.
		 * 
		 * @param string $name The name.
		 */
		public function setName($name) 
		{
			$this->name = $name;
		}

		/**
		 * Sets the url of the menu entry.
		 * 
		 * @param string $url The url.
		 */
		public function setUrl($url) 
		{
			$this->url = $url;
		}

		/**
		 * Returns the display name.
		 * 
		 * @return string
		 */
		public function getName() 
		{
			return $this->name;
		}

		/**
		 * Returns the url.
		 * 
		 * @return string
		 */
		public function getUrl() 
		{
			return $this->url;
		}

		/**
		 * Sets the required access to view the menu entry.
		 * 
		 * @param integer $requiredAccess The required access.
		 */
		public function setRequiredAccess($requiredAccess) 
		{
			$this->requiredAccess = $requiredAccess;
		}

		/**
		 * Returns the required access to view the menu entry.
		 * 
		 * @return integer
		 */
		public function getRequiredAccess() 
		{
			return $this->requiredAccess;
		}

		/**
		 * Returns whether a login is required to view the menu entry.
		 * 
		 * @return boolean
		 */
		public function getRequiresLogin()
		{
			return $this->requiresLogin;
		}

		/**
		 * Sets whether a login is required to view the menu entry.
		 * 
		 * @param boolean $requiresLogin Whether a login is required.
		 */
		public function setRequiresLogin($requiresLogin) 
		{
			$this->requiresLogin = $requiresLogin;
		}

		/**
		 * Returns whether a login is required to view the menu entry.
		 * 
		 * @return boolean
		 */
		public function requiresLogin() 
		{
			return $this->requiresLogin == 0 ? FALSE : TRUE;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\Model::toArray()
		 */
		public function toArray() 
		{
			return array(
				'name' => $this->getName(),
				'url' => $this->getUrl(),
				'requiredAccess' => $this->getRequiredAccess(),
				'requiresLogin' => $this->getRequiresLogin()
			);
		}
	}
