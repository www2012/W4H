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
 * @ORM\Entity
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
     * @ORM\Column(type="string", length=64)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Assert\Url()
     */
    protected $website_url;

    public function __toString()
    {
        return $this->getName();
    }

    public function slugify()
    {
        return 'Event';
        die('test');
        var_dump(Urlizer::urlize($this->getName()));die();
        return Urlizer::urlize($this->getName());
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
}
