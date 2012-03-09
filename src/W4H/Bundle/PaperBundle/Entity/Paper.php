<?php
namespace W4H\Bundle\PaperBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Table(name="paper")
 * @ORM\Entity(repositoryClass="W4H\Bundle\PaperBundle\Repository\PaperRepository")
 */
class Paper
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $paper_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $authors;

    public function __toString()
    {
        return sprintf('%s - %s (%s)',
          $this->getPaperNumber(),
          $this->getTitle(),
          $this->getAuthors()
        );
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
     * Set paper_number
     *
     * @param string $paperNumber
     */
    public function setPaperNumber($paperNumber)
    {
        $this->paper_number = $paperNumber;
    }

    /**
     * Get paper_number
     *
     * @return string 
     */
    public function getPaperNumber()
    {
        return $this->paper_number;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set authors
     *
     * @param string $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * Get authors
     *
     * @return string 
     */
    public function getAuthors()
    {
        return $this->authors;
    }
}