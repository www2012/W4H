<?php
namespace W4H\Bundle\LocationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class LocationRepository extends EntityRepository
{
    /**
     * Get all locations ordered by name ASC query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderedByNameQueryBuilder()
    {
        return $this->createQueryBuilder('l')->orderBy('l.name', 'ASC');
    }

    /**
     * Get all locations ordered by name ASC query
     *
     * @return DoctrineQuery
     */
    public function findAllOrderedByNameQuery()
    {
        return $this->findAllOrderedByNameQueryBuilder()->getQuery();
    }

    /**
     * Get all locations ordered by name ASC
     *
     * @return Collection Location
     */
    public function findAllOrderedByName()
    {
        return $this->findAllOrderedByNameQuery()->getResult();
    }

    /**
     * Get specified locations ordered by name ASC
     *
     * @return Collection Location
     */
    public function findByIds($ids)
    {
        $qb = $this->findAllOrderedByNameQueryBuilder();

        $qb->where('l.id IN (:ids)')
           ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}

