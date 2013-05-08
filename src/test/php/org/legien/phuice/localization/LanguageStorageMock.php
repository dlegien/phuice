<?php

	namespace org\legien\phuice\localization;
	
	use org\legien\phuice\testing\AbstractMock;
	
	class LanguageStorageMock extends AbstractMock implements LanguageStorage
	{	
		/**
		 * Returns all languages in the storage.
		 *
		 * @return	array
		 */
		public function findAll()
		{
			$this->registerCall('LanguageStorageMock', 'findAll', array());
			return $this->getReturnValue(__FUNCTION__);
		}
	}