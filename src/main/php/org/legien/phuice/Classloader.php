<?php

	namespace org\legien\phuice;

	use org\legien\phuice\exceptions\ClassNotFoundException;

	class Classloader {

		protected $loaders = array();

		public function __construct($loaders = array()) {
			foreach((array) $loaders as $key => $value) {
				$this->setPathClosure($key, $value);
			}
			spl_autoload_register(array($this, 'loader'));
		}

		protected function setPathClosure($name, $code) {
			$this->loaders[$name] = $code;
		}

		protected function loader($className) {
			foreach($this->loaders as $value) {
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
