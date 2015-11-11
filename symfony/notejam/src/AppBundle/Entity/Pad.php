<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PadRepository")
 */
class Pad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User", inversedBy="pads")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Note", mappedBy="pad", cascade={"remove"})
     */
    protected $notes;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Get notes
     *
     * @return Notes
     */
    public function getNotes() {
        return $this->notes;
    }
}
