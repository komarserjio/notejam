<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{

	const
		TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_EMAIL = 'email',
		COLUMN_PASSWORD_HASH = 'password';


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
			throw new Nette\Security\AuthenticationException(sprintf('Unknown user %s', $email), self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('Invalid password', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update(array(
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		return new Nette\Security\Identity($row[self::COLUMN_ID], null, $arr);
	}


	/**
	 * Adds new user.
	 * @param string $username
	 * @param string $password
	 * @throws DuplicateNameException
	 */
	public function add($username, $password)
	{
		try {
			$this->database->table(self::TABLE_NAME)->insert(array(
				self::COLUMN_EMAIL         => $username,
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException("User with given email already registered");
		}
	}

	/**
	 * @param $id
	 * @param $password
	 * @return bool
	 */
	public function checkPassword($id, $password)
	{
		$user = $this->database->table(self::TABLE_NAME)->get($id);
		return $user && Passwords::verify($password, $user->{self::COLUMN_PASSWORD_HASH});
	}

	/**
	 * Changes password of the user with given id.
	 * @param int    $id
	 * @param string $new
	 * @return int
	 */
	public function setNewPassword($id,  $new)
	{
		return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->update([
			self::COLUMN_PASSWORD_HASH => Passwords::hash($new)
		]);
	}

	/**
	 * Finds user by given email.
	 * @param string $email
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	public function findByEmail($email)
	{
		return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_EMAIL, $email)->fetch();
	}

}


class DuplicateNameException extends \Exception
{

}
