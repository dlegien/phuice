<?php

	namespace org\legien\phuice\localization;

	use org\legien\phuice\mvc\Model;

	class Language implements Model {
	
		private $shortname;
		private $name;
	
		public function setShortname($shortname) {
			$this->shortname = $shortname;
		}

		public function getShortname() {
			return $this->shortname;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		public function toArray() {
			return array(
				'name' => $this->getName(),
				'shortname' => $this->getShortname()
			);
		}
	}