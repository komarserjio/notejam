<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Note
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Pad", inversedBy="notes")
     * @ORM\JoinColumn(name="pad_id", referencedColumnName="id")
     */
    private $pad;


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
     * Set user
     *
     * @param User user
     * @return Note
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
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
    public function setPad($pad)
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
        $this->updated_at = new \DateTime('now');
    }

    /**
     * Get last update time
     *
     * @return string formatted date
     */
    public function getUpdatedAt()
    {
        return $this->updated_at->format('d M. Y');
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
