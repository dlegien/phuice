<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\ViewWrapper;

	abstract class AbstractController {

		protected $view;

		public function __construct(ViewWrapper $view) {
			$this->view = $view;
		}

		public function renderView() {
			$this->view->render();
		}

		protected function getView() {
			return $this->view;
		}
		
		protected function redirect($redirect) {
			header("Location: $redirect");
		}
	}
