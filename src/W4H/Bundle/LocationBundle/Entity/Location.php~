<?php
namespace W4H\Bundle\LocationBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="location")
 * @ORM\Entity
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $building;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $classe_room_places;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $conference_room_places;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $standing_room_places;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $video_projector;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $sound;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $internet;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $other_devices;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $accessibility;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $longitude;

    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set building
     *
     * @param string $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set level
     *
     * @param integer $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set classe_room_places
     *
     * @param integer $classeRoomPlaces
     */
    public function setClasseRoomPlaces($classeRoomPlaces)
    {
        $this->classe_room_places = $classeRoomPlaces;
    }

    /**
     * Get classe_room_places
     *
     * @return integer 
     */
    public function getClasseRoomPlaces()
    {
        return $this->classe_room_places;
    }

    /**
     * Set conference_room_places
     *
     * @param integer $conferenceRoomPlaces
     */
    public function setConferenceRoomPlaces($conferenceRoomPlaces)
    {
        $this->conference_room_places = $conferenceRoomPlaces;
    }

    /**
     * Get conference_room_places
     *
     * @return integer 
     */
    public function getConferenceRoomPlaces()
    {
        return $this->conference_room_places;
    }

    /**
     * Set standing_room_places
     *
     * @param integer $standingRoomPlaces
     */
    public function setStandingRoomPlaces($standingRoomPlaces)
    {
        $this->standing_room_places = $standingRoomPlaces;
    }

    /**
     * Get standing_room_places
     *
     * @return integer 
     */
    public function getStandingRoomPlaces()
    {
        return $this->standing_room_places;
    }

    /**
     * Set video_projector
     *
     * @param boolean $videoProjector
     */
    public function setVideoProjector($videoProjector)
    {
        $this->video_projector = $videoProjector;
    }

    /**
     * Get video_projector
     *
     * @return boolean 
     */
    public function getVideoProjector()
    {
        return $this->video_projector;
    }

    /**
     * Set sound
     *
     * @param boolean $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    /**
     * Get sound
     *
     * @return boolean 
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * Set internet
     *
     * @param boolean $internet
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;
    }

    /**
     * Get internet
     *
     * @return boolean 
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * Set other_devices
     *
     * @param string $otherDevices
     */
    public function setOtherDevices($otherDevices)
    {
        $this->other_devices = $otherDevices;
    }

    /**
     * Get other_devices
     *
     * @return string 
     */
    public function getOtherDevices()
    {
        return $this->other_devices;
    }

    /**
     * Set accessibility
     *
     * @param string $accessibility
     */
    public function setAccessibility($accessibility)
    {
        $this->accessibility = $accessibility;
    }

    /**
     * Get accessibility
     *
     * @return string 
     */
    public function getAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}