<?php
namespace W4H\Bundle\EventTaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
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
     */
    protected $starts_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $ends_at;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Activity")
     */
    protected $activity;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Role")
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Event")
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\LocationBundle\Entity\Location")
     */
    protected $location;

    public function __toString()
    {
        return sprintf("Tâche %s effectuée par BIBI à %s pour l'évènement %s", $this->getActivity(), $this->getLocation(), $this->getEvent());
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
     * Set role
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\Role $role
     */
    public function setRole(\W4H\Bundle\EventTaskBundle\Entity\Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return W4H\Bundle\EventTaskBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
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
}
