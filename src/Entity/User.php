<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "Users")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 120)]
    private $fullname;

    #[ORM\Column(type: 'string')]
    private $sexe;

    #[ORM\Column(type: 'integer')]
    private $age;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'promotedBy')]
    private $promoteEvent;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'eventParticipated')]
    private $participateToEvent;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->promoteEvent = new ArrayCollection();
        $this->participateToEvent = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of sexe
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set the value of sexe
     *
     * @return  self
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of promoteEvent
     */
    public function getPromoteEvent()
    {
        return $this->promoteEvent;
    }

    /**
     * add the value of article
     *
     * @return  self
     */
    public function addPromoteEvent(Event $event)
    {
        if (!$this->promoteEvent->contains($event)) {
            $this->promoteEvent->add($event);
            $event->setPromotedBy($this);
        }
        return $this;
    }

    public function removePromoteEvent(Event $event)
    {
        if ($this->promoteEvent->removeElement($event)) {
            if ($event->getPromotedBy() === $this) {
                $event->setPromotedBy(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of participateToEvent
     */
    public function getParticipateToEvent()
    {
        return $this->participateToEvent;
    }

    /**
     * Set the value of participateToEvent
     *
     * @return  self
     */
    public function setParticipateToEvent($participateToEvent)
    {
        $this->participateToEvent = $participateToEvent;

        return $this;
    }

    /**
     * Set the value of participateToEvent
     */
    public function addParticipateToEvent(Event $event): self
    {
        if (!$this->participateToEvent->contains($event)) {
            $this->participateToEvent->add($event);
            if (!$event->getEventParticipated()->contains($this)) {
                $event->addEventParticipated($this);
            }
        }

        return $this;
    }
    public function removeParticipateToEvent(Event $event): self
    {
        if ($this->participateToEvent->removeElement($event)) {
            if ($event->getEventParticipated()->contains($this)) {
                $event->removeEventParticipated($this);
            }
        }

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at->format("Y-m-d H:i:s");
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}