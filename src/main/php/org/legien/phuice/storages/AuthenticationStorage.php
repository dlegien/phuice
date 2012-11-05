<?php

	namespace org\legien\phuice\storages;

	interface AuthenticationStorage {

		public function findByUsername($username);

	}
