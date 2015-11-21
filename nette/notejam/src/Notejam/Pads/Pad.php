<?php

namespace Notejam\Pads;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Notejam\Notes\Note;
use Notejam\Users\User;



/**
 * @ORM\Table(name="pads")
 * @ORM\Entity(repositoryClass="Notejam\Pads\PadRepository")
 */
class Pad
{

	use Identifier;
	use MagicAccessors;

	/**
	 * @ORM\Column(name="name", type="string", length=100)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="Notejam\Users\User", inversedBy="pads")
	 * @ORM\JoinColumn(nullable=false)
	 * @var User
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="Notejam\Notes\Note", mappedBy="pad", cascade={"remove"})
	 * @var Note[]|ArrayCollection
	 */
	protected $notes;



	public function __construct(User $user)
	{
		$this->user = $user;
		$this->notes = new ArrayCollection();
	}



	/**
	 * @param string $name
	 * @return Pad
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}



	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}



	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}



	/**
	 * @param User user
	 * @return Pad
	 */
	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getName();
	}

}
