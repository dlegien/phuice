<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\View;

	abstract class AbstractController {

		protected $view;

		public function __construct(View $view) {
			$this->view = $view;
		}
	}
