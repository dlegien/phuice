<?php

	namespace org\legien\phuice;

	use org\legien\phuice\exceptions\ClassNotFoundException;

	class Classloader {

		private static $_instance = NULL;

		protected $_loaders = array();

		private function __construct() {
			spl_autoload_register(array($this, 'loader'));
		}

		protected function setPathClosure($name, $code) {
			$this->_loaders[$name] = $code;
		}

		public function addLoaders($loaders = array()) {
			foreach((array) $loaders as $key => $value) {
				$this->setPathClosure($key, $value);
			}
		}

		public function getInstance() {
			if(is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		protected function loader($className) {
			foreach($this->_loaders as $value) {
				$filename = $value($className);
				if(is_readable($filename)) {
					include_once($filename);
					break;
				}
			}

			if(class_exists($className, FALSE) === FALSE && interface_exists($className, FALSE) === FALSE) {
				throw new ClassNotFoundException('Class ' . $className . ' could not be loaded.');
			}
		}
	}
