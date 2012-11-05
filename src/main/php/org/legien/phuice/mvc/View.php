<?php

	namespace org\legien\phuice\mvc;

	interface View {

		public function assign($name, $value);

		public function render();

	}
