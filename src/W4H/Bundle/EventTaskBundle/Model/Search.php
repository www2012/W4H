<?php
namespace W4H\Bundle\EventTaskBundle\Model;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 * @ORM\Entity()
 */
class Search
{
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $query;

    /**
     * Set query
     *
     * @param string $search
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Get query
     *
     * @return string 
     */
    public function getQuery()
    {
        return $this->query;
    }
}
