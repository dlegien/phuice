<?php

	namespace org\legien\phuice\authentication\hashing;
	
	use org\legien\phuice\authentication\HashWrapper;
	
	class CryptHashWrapper implements HashWrapper {
		
		public function hashPassword($password, $salt = NULL) {
			
			if(!is_null($salt)) {
				return crypt($password, $salt);	
			}
			else {
				return crypt($password);
			}
		}
		
		public function verifyPassword($hash, $input) {
			return crypt($input, $hash) == $hash;
		}
	}
