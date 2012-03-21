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
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id", onDelete="Cascade")
     */
    protected $activity;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\EventTaskBundle\Entity\Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="Cascade")
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="W4H\Bundle\LocationBundle\Entity\Location")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", onDelete="Cascade")
     */
    protected $location;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $room_configuration;

    /**
     * @ORM\OneToMany(targetEntity="W4H\Bundle\EventTaskBundle\Entity\TaskOwner", mappedBy="task", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    public $owners;

    /**
     * @ORM\OneToMany(targetEntity="W4H\Bundle\PaperBundle\Entity\PaperPresenter", mappedBy="task", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    public $paper_presenters;

    public function __toString()
    {
        return sprintf("%d] %s - %s",
            $this->getId(),
            $this->getEvent(),
            $this->getActivity()
        );
    }

    public function __construct()
    {
        $this->owners = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getClasses()
    {
        return sprintf("%s %s",
          Utils::slugify($this->getEvent()->getName()),
          Utils::slugify($this->getActivity()->getActivityType()->getName())
        );
    }

    /**
     * Add owners proxy
     *
     * @param W4H\Bundle\EventTaskBundle\Entity\TaskOwner $owners
     */
    public function addOwners(\W4H\Bundle\EventTaskBundle\Entity\TaskOwner $owners)
    {
        $this->addTaskOwner($owners);
    }

    /**
     * Add paper_presenters proxy
     *
     * @param W4H\Bundle\PaperBundle\Entity\PaperPresenter $paperPresenters
     */
    public function addPaperPresenters(\W4H\Bundle\PaperBundle\Entity\PaperPresenter $paperPresenters)
    {
        $this->addPaperPresenter($paperPresenters);
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

    /**
     * Set Room configuration
     *
     * @param string $room_configuration
     */
    public function setRoomConfiguration($room_configuration)
    {
        $this->room_configuration = $room_configuration;
    }

    /**
     * Get Room configuration
     *
     * @return string
     */
    public function getRoomConfiguration()
    {
        return $this->room_configuration;
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

    /**
     * Add paper_presenters
     *
     * @param W4H\Bundle\PaperBundle\Entity\PaperPresenter $paperPresenters
     */
    public function addPaperPresenter(\W4H\Bundle\PaperBundle\Entity\PaperPresenter $paperPresenters)
    {
        $this->paper_presenters[] = $paperPresenters;
    }

    /**
     * Get paper_presenters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPaperPresenters()
    {
        return $this->paper_presenters;
    }

    public function getVcal()
    {
      $version      = '2.0';
      $prodid       = '//W4H//Free Web Application//EN';
      $category     = sprintf('%s - %s',
        $this->getEvent()->getName(),
        $this->getActivity()->getActivityType()->getName()
      );
      $dtstart      = $this->getStartsAt()->format("Ymd\THis\Z");
      $dtend        = $this->getEndsAt()->format("Ymd\THis\Z");
      $summary      = sprintf('%s - %s - %s',
        $this->getEvent()->getName(),
        $this->getActivity()->getActivityType()->getName(),
        $this->getActivity()->getName()
      );
      $description  = strip_tags($this->getActivity()->getDescription());
      $location     = sprintf('%s - %s',
        $this->getLocation()->getName(),
        $this->getLocation()->getBuilding()
      );

      return sprintf('BEGIN:VCALENDAR
VERSION:%s
PRODID:%s
BEGIN:VTIMEZONE
TZID:Europe/Paris
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
DTSTART:19810329T020000
TZNAME:GMT+02:00
TZOFFSETTO:+0200
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU
DTSTART:19961027T030000
TZNAME:GMT+01:00
TZOFFSETTO:+0100
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
CATEGORIES:%s
DTSTART;TZID=Europe/Paris:%s
DTEND;TZID=Europe/Paris:%s
SUMMARY:%s
DESCRIPTION:%s
LOCATION:%s
END:VEVENT
END:VCALENDAR', $version, $prodid, $category, $dtstart, $dtend, $summary, $description, $location);
    }
}
