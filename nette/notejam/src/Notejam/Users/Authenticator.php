<?php

namespace Notejam\Users;

use Nette;
use Nette\Security\AuthenticationException;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class Authenticator implements Nette\Security\IAuthenticator
{

	/**
	 * @var UserRepository
	 */
	private $userRepository;



	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}



	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		if (!$user = $this->userRepository->findOneBy(['email' => $username])) {
			throw new AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);

		} elseif (!$user->verifyPassword($password)) {
			throw new AuthenticationException('Invalid password.', self::INVALID_CREDENTIAL);
		}

		return $user;
	}

}
