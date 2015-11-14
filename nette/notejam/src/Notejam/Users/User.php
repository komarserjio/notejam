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
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="Notejam\Pads\Pad", mappedBy="user")
     */
    protected $pads;

    /**
     * @ORM\OneToMany(targetEntity="Notejam\Notes\Note", mappedBy="user")
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
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }


    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }



    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }



    /**
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



    /***
     * @return string
     */
    public function generateRandomPassword()
    {
        $password = Random::generate(10);
        $this->password = Passwords::hash($password);
        return $password;
    }



    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return Passwords::verify($password, $this->password);
    }



    /**
     * @return bool
     */
    public function passwordNeedsRehash()
    {
        return Passwords::needsRehash($this->password);
    }

}
