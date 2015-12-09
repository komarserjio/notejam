<?php

namespace Notejam\Notes;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Notejam\Pads\Pad;
use Notejam\Users\User;



/**
 * @ORM\Table(name="notes")
 * @ORM\Entity(repositoryClass="Notejam\Notes\NoteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Note
{

	use Identifier;
	use MagicAccessors;

	/**
	 * @ORM\Column(name="name", type="string", length=100)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\Column(name="text", type="text")
	 * @var string
	 */
	private $text;

	/**
	 * @ORM\ManyToOne(targetEntity="Notejam\Users\User", inversedBy="notes")
	 * @ORM\JoinColumn(nullable=FALSE)
	 * @var User
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="Notejam\Pads\Pad", inversedBy="notes")
	 * @var Pad
	 */
	private $pad;

	/**
	 * @ORM\Column(name="updated_at", type="datetime")
	 * @var \Datetime
	 */
	private $updatedAt;



	public function __construct(User $user)
	{
		$this->user = $user;
	}



	/**
	 * @param string $name
	 * @return Note
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
	 * @param string $text
	 * @return Note
	 */
	public function setText($text)
	{
		$this->text = $text;
		return $this;
	}



	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}



	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}



	/**
	 * @return Pad
	 */
	public function getPad()
	{
		return $this->pad;
	}



	/**
	 * @param Pad pad
	 * @return Note
	 */
	public function setPad(Pad $pad = null)
	{
		$this->pad = $pad;
		return $this;
	}



	/**
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function setUpdatedAt()
	{
		$this->updatedAt = new \DateTime('now');
	}



	/**
	 * @return \Datetime
	 */
	public function getUpdatedAt()
	{
		return clone $this->updatedAt;
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getName();
	}
}
