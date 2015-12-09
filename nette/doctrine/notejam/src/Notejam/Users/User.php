<?php

namespace Notejam\Users;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Utils\Random;
use Notejam\InvalidPasswordException;
use Notejam\Notes\Note;
use Notejam\Pads\Pad;



/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Notejam\Users\UserRepository")
 */
class User implements IIdentity
{

	use Identifier;
	use MagicAccessors;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 * @var string
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=64)
	 * @var string
	 */
	private $password;

	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 * @var boolean
	 */
	private $active;

	/**
	 * @ORM\OneToMany(targetEntity="Notejam\Pads\Pad", mappedBy="user")
	 * @var Pad[]|ArrayCollection
	 */
	protected $pads;

	/**
	 * @ORM\OneToMany(targetEntity="Notejam\Notes\Note", mappedBy="user")
	 * @var Note[]|ArrayCollection
	 */
	protected $notes;



	public function __construct($email, $password)
	{
		$this->email = $email;
		$this->password = Passwords::hash($password);
		$this->active = true;

		$this->pads = new ArrayCollection();
		$this->notes = new ArrayCollection();
	}



	/**
	 * List of string roles of the user.
	 *
	 * @return array
	 */
	public function getRoles()
	{
		return array('user');
	}



	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}



	/**
	 * @return boolean
	 */
	public function isActive()
	{
		return $this->active;
	}



	/**
	 * Changes the password, only if the right original password is provided.
	 *
	 * @param string $original
	 * @param string $password
	 * @throws InvalidPasswordException
	 */
	public function changePassword($original, $password)
	{
		if (!$this->verifyPassword($original)) {
			throw new InvalidPasswordException('Wrong password');
		}

		$this->password = Passwords::hash($password);
	}



	/**
	 * Generates a random password that can be used when the user forgots the orignal.
	 * In real app, this shouldn't overwrite the current password,
	 * it should be in another field, or even better a whole new table.
	 *
	 * @return string
	 */
	public function generateRandomPassword()
	{
		$password = Random::generate(10);
		$this->password = Passwords::hash($password);
		return $password;
	}



	/**
	 * Verifies if given password is the same as the original hashed password.
	 *
	 * @param string $password
	 * @return bool
	 */
	public function verifyPassword($password)
	{
		return Passwords::verify($password, $this->password);
	}



	/**
	 * If the password was hashed with too small cost, this method can tell you that,
	 * so you can regenerate the hash with higher cost.
	 *
	 * @return bool
	 */
	public function passwordNeedsRehash()
	{
		return Passwords::needsRehash($this->password);
	}

}
