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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Notejam\Users\User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=FALSE)
     */
    private $user;

    /**
     * @var Pad
     *
     * @ORM\ManyToOne(targetEntity="Notejam\Pads\Pad", inversedBy="notes")
     */
    private $pad;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;



    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Note
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Note
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Get pad
     *
     * @return Pad
     */
    public function getPad()
    {
        return $this->pad;
    }


    /**
     * Set pad
     *
     * @param Pad pad
     * @return Note
     */
    public function setPad(Pad $pad = NULL)
    {
        $this->pad = $pad;
        return $this;
    }

    /**
     * Update timestamp
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Get last update time
     *
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return clone $this->updatedAt;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }
}
