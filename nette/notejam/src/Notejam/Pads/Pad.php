<?php

namespace Notejam\Pads;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Notejam\Users\User", inversedBy="pads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Notejam\Notes\Note", mappedBy="pad", cascade={"remove"})
     */
    protected $notes;



    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Pad
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
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set user
     *
     * @param User user
     * @return Pad
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
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
