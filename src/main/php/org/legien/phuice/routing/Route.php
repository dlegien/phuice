<?php

	namespace org\legien\phuice\routing;

	class Route {
	
		private $isMatched = FALSE;
		private $isProcessed = FALSE;
		private $route;
		private $target;
		private $conditions;

		public function __construct($route, $target = array(), $conditions = array()) {
			$this->route = $route;
			$this->target = $target;
			$this->conditions = $conditions;
		}

		public function isMatched() {
			return $this->isMatched;
		}

		public function matchWith($path) {
			
			$parameterNames = array();
			preg_match_all('@:([\w]+)@', $this->route, $parameterNames, PREG_PATTERN_ORDER);

			$regex = preg_replace_callback('@:[\w]+@', array($this, 'regex'), $this->route);
			$regex .= '/?';
	
			if(preg_match('@^'.$regex.'$@', $path, $parameters)) {
				foreach($parameterNames[0] as $index => $value) {
					$this->parameters[substr($value,1)] = urldecode($parameters[$index+1]);
				}
				foreach($this->target as $key => $value) {
					$this->parameters[$key] = $value;
				}
				$this->setMatched(TRUE);
			}
			$this->setProcessed(TRUE);
		}

		private function setMatched($matched) {
			$this->isMatched = $matched;
		}

		private function setProcessed($processed) {
			$this->isProcessed = $processed;
		}

		private function isProcessed() {
			return $this->isProcessed;
		}

		public function getParameters() {
			if($this->isProcessed() && $this->isMatched()) {
				return $this->parameters;
			} elseif($this->isProcessed) {
				throw new \Exception('Route did not match.');
			} else {
				throw new \Exception('Has to be matched before retrieving parameters.');
			}
		}

		public function getParameter($name) {
			if(isset($this->parameters[$name])) {
				return $this->parameters[$name];
			}
		}	

		public function getRoute() {
			return $this->route;
		}

		private function regex($matches) {
			return '([a-zA-Z0-9_\+\-%]+)';
		}
	}
