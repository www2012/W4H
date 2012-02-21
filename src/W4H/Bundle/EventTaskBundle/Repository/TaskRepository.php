<?php
namespace W4H\Bundle\EventTaskBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class TaskRepository extends EntityRepository
{
    /**
     * Get all tasks ordered by name ASC query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderedByNameQueryBuilder()
    {
        return $this->createQueryBuilder('p')->orderBy('p.name', 'ASC');
    }

    /**
     * Get all tasks ordered by name ASC query
     *
     * @return DoctrineQuery
     */
    public function findAllOrderedByNameQuery()
    {
        return $this->findAllOrderedByNameQueryBuilder()->getQuery();
    }

    /**
     * Get all tasks ordered by name ASC
     *
     * @return Collection Task
     */
    public function findAllOrderedByName()
    {
        return $this->findAllOrderedByNameQuery()->getResult();
    }

    /**
     * Get all tasks matching filters query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllFilteredQueryBuilder($starts_at, $filters = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select(array('task', 'owners', 'person', 'role'))
           ->from('W4HEventTaskBundle:Task', 'task')
           ->leftJoin('task.activity', 'activity')
           ->leftJoin('task.event', 'event')
           ->leftJoin('task.location', 'location')
           ->leftJoin('activity.activity_type', 'activity_type')
           ->leftJoin('task.owners', 'owners')
           ->leftJoin('owners.person', 'person')
           ->leftJoin('owners.role', 'role')
           ->where($qb->expr()->eq($qb->expr()->substring('task.starts_at', 1, 10), ':starts_at'))
           ->setParameter('starts_at', $starts_at);

        if(count($filters) > 0)
        {
            foreach($filters as $field => $filter)
            {
                if(count($filter) > 0)
                {
                    $ids = array();
                    foreach($filter as $selected_object)
                        $ids[] = $selected_object->getId();

                    $column = sprintf('%s.id', $field);
                    $qb->andWhere($qb->expr()->in($column, $ids));
                 }
            }
        }

        return $qb;
    }

    /**
     * Get all tasks matching filters query
     *
     * @return DoctrineQuery
     */
    public function findAllFilteredQuery($starts_at, $filters = null)
    {
        return $this->findAllFilteredQueryBuilder($starts_at, $filters)->getQuery();
    }

    /**
     * Get all tasks matching filters query
     *
     * @return Collection Task
     */
    public function findAllFiltered($starts_at, $filters = null)
    {
        return $this->findAllFilteredQuery($starts_at, $filters)->getResult();
    }
}
