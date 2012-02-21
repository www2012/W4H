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
class UserRepository extends EntityRepository
{
    /**
     * Get all users ordered by last name ASC query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderedByLastNameQueryBuilder()
    {
        return $this->createQueryBuilder('p')->orderBy('p.last_name', 'ASC');
    }

    /**
     * Get all users ordered by last name ASC query
     *
     * @return DoctrineQuery
     */
    public function findAllOrderedByLastNameQuery()
    {
        return $this->findAllOrderedByLastNameQueryBuilder()->getQuery();
    }

    /**
     * Get all users ordered by last name ASC
     *
     * @return Collection User
     */
    public function findAllOrderedByLastName()
    {
        return $this->findAllOrderedByLastNameQuery()->getResult();
    }
}
