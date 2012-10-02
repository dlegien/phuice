<?php

	require_once('phar://build/phuice.phar');

	use org\legien\phuice\mvc;

	class BlogView extends mvc\AbstractHtmlView {

		public function __construct($title) {
			parent::__construct();
			$this->setTitle($title);
		}

	}

	class BlogController extends mvc\AbstractController {

		public function showOverview() {
			return $this->view->toString();
		}

	}

	$c = new BlogController(
		new BlogView('Test Page')
	);
	echo $c->showOverview();
