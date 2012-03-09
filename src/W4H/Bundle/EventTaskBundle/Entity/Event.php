<?php
namespace W4H\Bundle\EventTaskBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="W4H\Bundle\EventTaskBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Assert\Url()
     */
    protected $website_url;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    protected $starts_on;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    protected $ends_on;

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
     * Set website_url
     *
     * @param string $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->website_url = $websiteUrl;
    }

    /**
     * Get website_url
     *
     * @return string 
     */
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }

    /**
     * Set starts_on
     *
     * @param date $startsOn
     */
    public function setStartsOn($startsOn)
    {
        $this->starts_on = $startsOn;
    }

    /**
     * Get starts_on
     *
     * @return date
     */
    public function getStartsOn()
    {
        return $this->starts_on;
    }

    /**
     * Set ends_on
     *
     * @param date $endsOn
     */
    public function setEndsOn($endsOn)
    {
        $this->ends_on = $endsOn;
    }

    /**
     * Get ends_on
     *
     * @return date
     */
    public function getEndsOn()
    {
        return $this->ends_on;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}