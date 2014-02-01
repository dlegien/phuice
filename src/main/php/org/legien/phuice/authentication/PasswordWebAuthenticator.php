<?php

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\authentication\WebAuthenticator;
	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\authentication\HashWrapper;

	/**
	 * A web authenticator for the use with passwords.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	authentication
	 */
	class PasswordWebAuthenticator implements WebAuthenticator 
	{
		/**
		 * The view.
		 *
		 * @var	ViewWrapper
		 */
		private $_view;
		
		/**
		 * The gateway to the authentication information.
		 * 
		 * @var	AuthenticationStorage
		 */
		private $_gateway;
		
		/**
		 * The session manager.
		 * 
		 * @var	SessionManager
		 */
		private $_sessionManager;
		
		/**
		 * The hash wrapper.
		 * 
		 * @var	HashWrapper
		 */
		private $_hashWrapper;

		/**
		 * Creates a new instance.
		 * 
		 * @param	ViewWrapper				$view			The view.
		 * @param	AuthenticationStorage	$gateway		The gateway to authentication information.
		 * @param	SessionManager			$sessionManager	The session manager.
		 * @param	HashWrapper				$hashWrapper	The hash wrapper.
		 */
		public function __construct(ViewWrapper $view, AuthenticationStorage $gateway, SessionManager $sessionManager, HashWrapper $hashWrapper) 
		{
			$this->setView($view);
			$this->setGateway($gateway);
			$this->setSessionManager($sessionManager);
			$this->setHashWrapper($hashWrapper);
		}
		
		/**
		 * Sets the hash wrapper.
		 * 
		 * @param	HashWrapper	$hashwrapper	The hash wrapper.
		 */
		private function setHashWrapper(HashWrapper $hashwrapper) 
		{
			$this->_hashWrapper = $hashwrapper;
		}

		/**
		 * Sets the session manager.
		 * 
		 * @param	SessionManager	$sessionManager	The session manager.
		 */
		private function setSessionManager(SessionManager $sessionManager) 
		{
			$this->_sessionManager = $sessionManager;
		}

		/**
		 * Sets the storage for authentication information.
		 * 
		 * @param	AuthenticationStorage	$gateway	The storage for authentication information.
		 */
		private function setGateway(AuthenticationStorage $gateway) 
		{
			$this->_gateway = $gateway;
		}

		/**
		 * Returns the session manager
		 * 
		 * @return	SessionManager
		 */
		private function getSessionManager() 
		{
			return $this->_sessionManager;
		}

		/**
		 * Returns the storage for authentication information.
		 * 
		 * @return	AuthenticationStorage
		 */
		private function getGateway() 
		{
			return $this->_gateway;
		}
		
		/**
		 * Returns the hash wrapper.
		 * 
		 * @return	HashWrapper
		 */
		private function getHashWrapper() 
		{
			return $this->_hashWrapper;
		}

		/**
		 * Returns whether the user is authenticated. This resolves to true
		 * if the session manager reports an active and valid session.
		 * 
		 * @return	boolean
		 */
		public function isAuthenticated() 
		{
			if($this->getSessionManager()->hasActiveSession()) 
			{
				return TRUE;
			}
			return FALSE;
		}

		/**
		 * Verifies a password using the given hash.
		 * 
		 * @param	string	$hash	The hash.
		 * @param	string	$input	The password.
		 * 
		 * @return	boolean
		 */
		public function verifyPassword($hash, $input) 
		{
			return $this->getHashWrapper()->verifyPassword($hash, $input);
		}


		/**
		 * Verifies that a password fullfills some policies defined
		 * Policies are: 1) At least 6 chars
		 *				 2) At least one letter and one number
		 *				 3) Cannot be equal to username
		 * 
		 * @param	string	$password	The password.
		 * 
		 * @return	boolean
		 */
		public function checkPasswordPolicy($password, $username)
		{
			$errors = array();

			if (empty($password)) 
			{
				$errors[] =  $this->getView()->translate('L_NEW_PASSWORD_CANNOT_BE_EMPTY');
			}
			else
			{
				if (strlen($password) < 6)
				{
					$errors[] = $this->getView()->translate('L_PASSWORD_MUST_HAVE_6_CHARS');
				}

				if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password))
				{
					$errors[] = $this->getView()->translate('L_PASSWORD_MUST_HAVE_ONE_LETTER_ONE_NO'); "";
				}

				if (strpos($username, $password) !== false)
				{
					$errors[] =  $this->getView()->translate('L_PASSWORD_CANNOT_BE_IN_LOGIN_NAME');
				}				
			}

			return $errors;
		}

		/**
		 * Authenticates the user by verifying the password, starting a
		 * session and redirecting the user.
		 * 
		 * @param	string	$username	The username.
		 * @param	string	$password	The password.
		 * @param	string	$redirect	Where to redirect the user.
		 */
		public function authenticate($username, $password, $redirect) 
		{
			$gateway = $this->getGateway();
			if($user = $gateway->findByUsername($username)) 
			{
				if ($user->hasToResetPassword())
				{
					$this->redirect('/passwordrecovery/resetpassword/'.$user->getId().'/');
					exit;
				}

				if($user->isActive() && $this->verifyPassword($user->getLoginPassword(), $password)) 
				{
					$this->getSessionManager()->startSession($user->getId(), time());
					$this->getSessionManager()->setLanguage($user->getLanguage());
					$this->redirect($redirect);
				}
				else
				{
					$this->renderFailure($redirect, 'credentials');
				}
			}
			else 
			{
				$this->renderFailure($redirect, 'credentials');
			}
		}



		/**
		 * Resets the user password considering doesn't know the old password, and redirects the user to the login.
		 * 
		 * @param	int		$id			The user id.
		 * @param	Request	$request	The request passed as parameter.
		 */
		public function forgotpassword($request) 
		{
			$this->getView()->type = "forgotpassword";
			$gateway = $this->getGateway();

			$token = $request->getParameter('token');
			
			$user = $gateway->findByToken($token);
			
			$error = "";
			$msg = "";
			if ($user)
			{
				if ($user->getToken() && strtotime($user->getTokenTime()) + 60*60 < strtotime(date('Y-m-d')))
				{
					$this->redirect('/home/');
					$_SESSION['failure'] = $this->getView()->translate('L_TOKEN_EXPIRED');
				}
				else
				{
					$submit = $request->getParameter('submit');
					if ($submit)
					{
						$newPassword = $request->getParameter('new-password');
						$repeatPassword = $request->getParameter('repeat-password');
						if ($newPassword != $repeatPassword)
						{
							$msg = $this->getView()->translate('L_NEW_PASSWORD_REPEAT_PASSWORD_MISSMATCH');
						}
						else
						{
							$msg = $this->checkPasswordPolicy($newPassword, $user->getLoginUsername());
							if (empty($msg))
							{
								$new_password = $this->getHashWrapper()->hashPassword($newPassword);
								$user->setPassword($new_password);
								$user->setResetPassword(0);
								$user->setToken(null);
								$user->setTokenTime(null);
								$gateway->update($user);
								$this->redirect('/home/');
							}
						}
					}
				}
			}
			else
			{
				$this->redirect('/home/');
				$_SESSION['failure'] = $this->getView()->translate('L_WRONG_TOKEN');
			}

			$this->getView()->msg = $msg;
			$this->getView()->token = $token;
			$this->getView()->error = $error;
			$this->getView()->render();
		}

		/**
		 * Resets the user password considering that the user knows the old password, and redirects the user to the login.
		 * 
		 * @param	int		$id			The user id.
		 * @param	Request	$request	The request passed as parameter.
		 */
		public function resetpassword($id, $request) 
		{

			$this->getView()->type = "resetpassword";
			$gateway = $this->getGateway();
			if($user = $gateway->findByPrimary($id)) 
			{
				$this->getView()->userid = $id;
				$this->getView()->username = $user->getLoginUsername();

				if ($user->hasToResetPassword())
				{
					$submit = $request->getParameter('submit');
					if ($submit)
					{
						$old_password = $request->getParameter('old-password');
						$new_password = $request->getParameter('new-password');
						$repeat_password = $request->getParameter('repeat-password');

						// ERROR CHECKING
						$errors = $this->checkPasswordPolicy($new_password, $user->getLoginUsername());
						if ($new_password == $old_password)
						{
							$errors[] = $this->getView()->translate('L_NEW_PASSWORD_IN_OLD_PASSWORD');
						}
						if (!($user->isActive() && $this->verifyPassword($user->getLoginPassword(), $old_password)))
						{
							$errors[] = $this->getView()->translate('L_WRONG_OLD_PASSWORD');
						}

						if ($new_password != $repeat_password)
						{
							$errors[] = $this->getView()->translate('L_NEW_PASSWORD_REPEAT_PASSWORD_MISSMATCH');
						}

						if(empty($errors)) 
						{
							$new_password = $this->getHashWrapper()->hashPassword($new_password);
							$user->setLoginPassword($new_password);
							$user->setResetPassword(0);
							$gateway->update($user);
							$this->redirect('/home/');
						}
						else
						{
							$this->getView()->error = $errors;
						}
					}

					$this->getView()->render();

				}
				else
				{
					$this->redirect('/login/home/');
				}
			}
			else 
			{
				$this->redirect('/login/home/');
			}
		}

		/**
		 * Logs the user out by destroying the session.
		 * 
		 * @param	string	$redirect	Where to redirect the user.
		 */
		public function logout($redirect) 
		{
			$this->getSessionManager()->destroySession();
			$this->redirect($redirect);
		}

		private function renderFailure($redirect, $failure) 
		{
			$this->getView()->redirect = $redirect;
			$this->getView()->failure = $this->getView()->translate('L_WRONG_CREDENTIALS');
			$this->getView()->render();
		}

		private function redirect($redirect) 
		{
			header('Location: ' . $this->getView()->urlunescape($redirect));
		}

		private function setView(ViewWrapper $view) {
			$this->_view = $view;
		}

		private function getView() {
			return $this->_view;
		}

		public function showAuthentication() {

			$this->getView()->redirect = $_SERVER['REDIRECT_URL'];
			$this->getView()->render();
		}

	}
