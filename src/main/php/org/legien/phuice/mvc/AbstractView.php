<?php

	namespace org\legien\phuice\mvc;

	abstract class AbstractView implements View {

		protected $variables;

		public function assign($name, $value) {
			if($this->variableExists($name)) {
				
			}
			else {
				$this->variables[$name] = $value;
			}
		}

		private function variableExists($name) {
			return key_exists($name, $this->variables);
		}

	}
