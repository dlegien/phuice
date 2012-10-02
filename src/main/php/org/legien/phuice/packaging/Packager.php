<?php

	namespace org\legien\phuice\packaging;

	class Packager {

		private $pharName;
		private $buildPath;
		private $srcPath;

		public function __construct($pharName, $buildPath, $srcPath) {
			$this->setPharName($pharName);
			$this->buildPath = $buildPath;
			$this->srcPath = $srcPath;
		}

		private function setPharName($pharName) {
			$this->pharName = $pharName;
		}

		public function getPharName() {
			return $this->pharName.'.phar';
		}

		public function setDefaultStub($stub) {
			$this->stub = $stub;
		}

		private function getStub() {
			return $this->stub;
		}

		private function getSrcPath() {
			return $this->srcPath;
		}

		private function getBuildPath() {
			return $this->buildPath;
		}

		private function getFileName() {
			return $this->getBuildPath().$this->getPharName();
		}

		public function package() {
			$phar = new \Phar($this->getFileName(), 0, $this->getPharName());
			$phar->buildFromIterator(
				new \RecursiveIteratorIterator(
					new \RecursiveDirectoryIterator($this->getSrcPath())
				), $this->getSrcPath()
			);
			$phar->setStub($phar->createDefaultStub($this->getStub()));
		}

	}
