<?php

namespace App\Entity;

require_once(dirname(dirname(__DIR__)) . "/bootstrap.php");

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "Events")]
class Event
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string')]
    private $imgUrl;

    #[ORM\Column(type: 'datetime')]
    private $datetime;

    #[ORM\Column(type: 'string')]
    private $slug;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'promoteEvent')]
    private $promotedBy;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participateToEvent')]
    private $eventParticipated;

    public function __construct()
    {
        $this->datetime = new \DateTime();
        $this->eventParticipated = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $slug = (new Slugify())->slugify($this->title);
        $this->setSlug($slug);
        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of datetime
     */
    public function getDatetime()
    {
        return $this->datetime->format("Y-m-d H:i:s");
    }

    /**
     * Set the value of datetime
     *
     * @return  self
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get the value of promotedBy
     */
    public function getPromotedBy()
    {
        return $this->promotedBy;
    }

    /**
     * Set the value of promotedBy
     *
     * @return  self
     */
    public function setPromotedBy($promotedBy)
    {
        $this->promotedBy = $promotedBy;

        return $this;
    }

    /**
     * Get the value of eventParticipated
     */
    public function getEventParticipated()
    {
        return $this->eventParticipated;
    }

    /**
     * Set the value of eventParticipated
     *
     * @return  self
     */
    public function setEventParticipated($eventParticipated)
    {
        $this->eventParticipated = $eventParticipated;

        return $this;
    }


    public function addEventParticipated(User $user): self
    {
        if (!$this->eventParticipated->contains($user)) {
            $this->eventParticipated->add($user);
            $user->addParticipateToEvent($this);
        }

        return $this;
    }

    public function removeEventParticipated(User $user): self
    {
        if ($this->eventParticipated->removeElement($user)) {

            if ($user->getParticipateToEvent()->contains($this)) {
                $user->removeParticipateToEvent($this);
            }
        }

        return $this;
    }

    /**
     * Get the value of imgUrl
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * Set the value of imgUrl
     *
     * @return  self
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}