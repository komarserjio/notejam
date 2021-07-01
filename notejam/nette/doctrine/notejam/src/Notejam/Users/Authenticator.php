<?php

namespace Notejam\Users;

use Nette;
use Nette\Security\AuthenticationException;



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



	/**
	 * Using the given email finds the user and verifies it's password.
	 * If the user is not fund or if the password is wrong, it throws.
	 *
	 * @param array $credentials
	 * @throws AuthenticationException
	 * @return User|NULL
	 */
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
