<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{

	/** @var Nette\Database\Context */
	private $database;

	/**
	 * UserManager constructor.
	 * @param Nette\Database\Context $database
	 */
	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	/**
	 * Performs an authentication.
	 * @param array $credentials
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;

		$row = $this->findByEmail($email);

		if (!$row) {
			throw new Nette\Security\AuthenticationException(sprintf('Unknown user', $email), self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row['password'])) {
			throw new Nette\Security\AuthenticationException('Invalid password', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row['password'])) {
			$row->update([
				'password' => Passwords::hash($password),
			]);
		}

		$arr = $row->toArray();
		unset($arr['password']);
		return new Nette\Security\Identity($row['id'], null, $arr);
	}


	/**
	 * Adds new user.
	 * @param string $email
	 * @param string $password
	 * @throws DuplicateNameException
	 */
	public function add($email, $password)
	{
		if ($this->getTable()->where('email', $email)->count() > 0) {
			throw new DuplicateNameException("User with given email already registered");
		}

		$this->getTable()->insert([
			'email'    => $email,
			'password' => Passwords::hash($password),
		]);
	}

	/**
	 * @param $id
	 * @param $password
	 * @return bool
	 */
	public function checkPassword($id, $password)
	{
		$user = $this->getTable()->get($id);
		return $user && Passwords::verify($password, $user->password);
	}

	/**
	 * Changes password of the user with given id.
	 * @param int    $id
	 * @param string $new
	 * @return int
	 */
	public function setNewPassword($id, $new)
	{
		return $this->getTable()->where('id', $id)->update([
			'password' => Passwords::hash($new)
		]);
	}

	/**
	 * Finds user by given email.
	 * @param string $email
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	public function findByEmail($email)
	{
		return $this->getTable()->where('email', $email)->fetch();
	}

	/**
	 * @return Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->database->table('users');
	}

}


class DuplicateNameException extends \Exception
{

}
