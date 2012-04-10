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

    /**
     * Get all persons matching filters
     *
     * @param array $filteredData
     * @return DoctrineQueryBuilder
     */
    public function findAllFilteredQueryBuilder($filteredData = array())
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select(array('task', 'owner', 'person', 'role'))
           ->from('W4HUserBundle:Person', 'person')
           ->leftJoin('person.owners', 'owner')
           ->leftJoin('owner.task', 'task')
           ->leftJoin('owner.role', 'role')
           ->leftJoin('task.location', 'location')
           ->leftJoin('task.activity', 'activity')
           ->leftJoin('task.event', 'event')
           ->leftJoin('activity.activity_type', 'activity_type')
           ->orderBy('person.last_name');

        if(count($filteredData) > 0)
        {
            foreach($filteredData as $field => $data)
            {
                if(count($data) > 0)
                {
                    if($field == 'from')
                    {
                        $qb->andWhere('task.starts_at >= :date_from')
                           ->setParameter('date_from', $data->format('Y-m-d'));
                    }
                    elseif($field == 'to')
                    {
                        $to = clone $data;
                        $to->modify("+1 day");
                        $qb->andWhere('task.ends_at <= :date_to')
                           ->setParameter('date_to', $to->format('Y-m-d'));
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
     * Get all persons matching filters
     *
     * @param array $filteredData
     * @return DoctrineQuery
     */
    public function findAllFilteredQuery($filteredData = array())
    {
        return $this->findAllFilteredQueryBuilder($filteredData)->getQuery();
    }

    /**
     * Get all persons matching filters
     *
     * @param array $filteredData
     * @return Collection Person
     */
    public function findAllFiltered($filteredData = array())
    {
        return $this->findAllFilteredQuery($filteredData)->getResult();
    }
}
