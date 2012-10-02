<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\AbstractView;

	abstract class AbstractHtmlView extends AbstractView {

		protected $title;

		protected function __construct() {
			$this->title = '';
		}

		protected function setTitle($title) {
			$this->title = $title;
		}

		private function getTitle() {
			return $this->title;
		}

		public function toString() {
			
			$output = '
<HTML>
	<HEAD>
		<TITLE>' . $this->getTitle() . '</TITLE>
	</HEAD>
	<BODY></BODY>
</HTML>';
			return $output;
			
		}

	}
