<?php
namespace W4H\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class GroupRepository extends EntityRepository
{
    /**
     * Get all groups ordered by name ASC query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderedByNameQueryBuilder()
    {
        return $this->createQueryBuilder('p')->orderBy('p.name', 'ASC');
    }

    /**
     * Get all groups ordered by name ASC query
     *
     * @return DoctrineQuery
     */
    public function findAllOrderedByNameQuery()
    {
        return $this->findAllOrderedByNameQueryBuilder()->getQuery();
    }

    /**
     * Get all groups ordered by name ASC
     *
     * @return Collection Group
     */
    public function findAllOrderedByName()
    {
        return $this->findAllOrderedByNameQuery()->getResult();
    }
}
