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
     * Get all tasks ordered by name ASC
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderedByNameQueryBuilder()
    {
        return $this->createQueryBuilder('p')->orderBy('p.name', 'ASC');
    }

    /**
     * Get all tasks ordered by name ASC
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
     * Get all tasks matching filters
     *
     * @param array $filteredData
     * @return DoctrineQueryBuilder
     */
    public function findAllFilteredQueryBuilder($filteredData = array())
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
           ->orderBy('task.starts_at');

        if(count($filteredData) > 0)
        {
            foreach($filteredData as $field => $data)
            {
                if(count($data) > 0)
                {
                    if($field == 'day')
                    {
                        $qb->where($qb->expr()->eq($qb->expr()->substring('task.starts_at', 1, 10), ':date_day'))
                           ->setParameter('date_day', $data->format('Y-m-d'));
                    }
                    elseif($field == 'from')
                    {
                        $qb->andWhere('task.starts_at >= :date_from')
                           ->setParameter('date_from', $data->format('Y-m-d'));
                    }
                    elseif($field == 'to')
                    {
                        $data->modify("+1 day");
                        $qb->andWhere('task.ends_at <= :date_to')
                           ->setParameter('date_to', $data->format('Y-m-d'));
                    }
                    else
                    {
                        $ids = array();
                        foreach($data as $object)
                            $ids[] = $object->getId();

                        $column = sprintf('%s.id', $field);
                        $qb->andWhere($qb->expr()->in($column, $ids));
                     }
                }
            }
        }

        return $qb;
    }

    /**
     * Get all tasks matching filters
     *
     * @param array $filteredData
     * @return DoctrineQuery
     */
    public function findAllFilteredQuery($filteredData = array())
    {
        return $this->findAllFilteredQueryBuilder($filteredData)->getQuery();
    }

    /**
     * Get all tasks matching filters
     *
     * @param array $filteredData
     * @return Collection Task
     */
    public function findAllFiltered($filteredData = array())
    {
        return $this->findAllFilteredQuery($filteredData)->getResult();
    }
}
