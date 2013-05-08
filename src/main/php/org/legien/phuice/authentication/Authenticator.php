<?php

	namespace org\legien\phuice\authentication;

	/**
	 * An authenticator.
	 */
	interface Authenticator 
	{
		/**
		 * Returns whether the user is authenticated. This resolves to true
		 * if the session manager reports an active and valid session.
		 *
		 * @return	boolean
		 */
		public function isAuthenticated();
	}
