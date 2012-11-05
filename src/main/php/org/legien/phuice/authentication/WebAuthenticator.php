<?php

	namespace org\legien\phuice\authentication;

	use org\legien\phuice\authentication\Authenticator;

	interface WebAuthenticator extends Authenticator {

		public function showAuthentication();

		public function hashPassword($password);

	}
