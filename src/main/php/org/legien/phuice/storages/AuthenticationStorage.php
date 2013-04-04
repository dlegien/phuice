<?php

	namespace org\legien\phuice\storages;

	interface AuthenticationStorage
	{
		public function findByUsername($username);	
		public function findByEmail($email);
	}