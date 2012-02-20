<?php
namespace W4H\Bundle\EventTaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use W4H\Bundle\CalendarBundle\Tool\Utils;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="W4H\Bundle\EventTaskBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $starts_at;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $ends_at;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Activity")
     */
    protected $activity;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Event")
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\LocationBundle\Entity\Location")
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="TaskOwner", mappedBy="task", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    public $owners;

    public function __toString()
    {
        return sprintf("%s - %s",
            $this->getEvent(),
            $this->getActivity()
        );
    }

    public function getClasses()
    {
        return sprintf("%s %s",
          Utils::slugify($this->getEvent()->getName()),
          Utils::slugify($this->getActivity()->getActivityType()->getName())
        );
    }

    /**
     * Count unit
     *
     * @param integer step (in minutes)
     * @return integer the number of step equal to the task duration
     */ 
    public function countUnit($step)
    {
        $duration = $this->getEndsAt()->getTimestamp() - $this->getStartsAt()->getTimestamp();
        return ceil($duration / 60 / $step);
    }

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
     * Set starts_at
     *
     * @param datetime $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->starts_at = $startsAt;
    }

    /**
     * Get starts_at
     *
     * @return datetime 
     */
    public function getStartsAt()
    {
        return $this->starts_at;
    }

    /**
     * Set ends_at
     *
     * @param datetime $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->ends_at = $endsAt;
    }

    /**
     * Get ends_at
     *
     * @return datetime 
     */
    public function getEndsAt()
    {
        return $this->ends_at;
    }

    /**
     * Set activity
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\Activity $activity
     */
    public function setActivity(\W4H\Bundle\EventTaskBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get activity
     *
     * @return W4H\Bundle\EventTaskBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set event
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\Event $event
     */
    public function setEvent(\W4H\Bundle\EventTaskBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return W4H\Bundle\EventTaskBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set location
     *
     * @param W4H\Bundle\LocationBundle\Entity\Location $location
     */
    public function setLocation(\W4H\Bundle\LocationBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return W4H\Bundle\LocationBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
    public function __construct()
    {
        $this->owners = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add owners
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\TaskOwner $owners
     */
    public function addTaskOwner(\W4H\Bundle\EventTaskBundle\Entity\TaskOwner $owners)
    {
        $this->owners[] = $owners;
    }

    /**
     * Get owners
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOwners()
    {
        return $this->owners;
    }
}
