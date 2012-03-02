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

    /**
     * Find all tasks order by Event
     *
     * @return DoctrineQueryBuilder
     */
    public function findAllOrderByDateQueryBuilder()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select(array('task', 'event', 'location', 'activity'))
           ->from('W4HEventTaskBundle:Task', 'task')
           ->leftJoin('task.activity', 'activity')
           ->leftJoin('task.event', 'event')
           ->leftJoin('task.location', 'location')
           ->leftJoin('activity.activity_type', 'activity_type')
           //->leftJoin('task.owners', 'owners')
           //->leftJoin('owners.person', 'person')
           //->leftJoin('owners.role', 'role')
           ->orderBy('task.starts_at');

        return $qb;
    }

    /**
     * Find all tasks ordered by Event
     *
     * @return DoctrineQuery
     */
    public function findAllOrderByDateQuery()
    {
        return $this->findAllOrderByDateQueryBuilder()->getQuery();
    }

    /**
     * Find all tasks sort by Event
     *
     * @return array of Task
     *
     * array('event_id' => array(
     *   'object' => Event
     *   'days' => array(
     *     '20120416' => array(
     *       'display' => 'April 16, 2012'
     *       'hours'   => array(
     *         '0900AM' => array(
     *           'display' => '09:00 AM'
     *           'tasks'   => TaskCollection,
     *         )
     *       )
     *     )
     *   )
     * );)
     */
    public function findAllSortByEvent()
    {
        $ret = array();
        $tasks = $this->findAllOrderByDateQuery()->getResult();
        foreach($tasks as $task)
        {
            if(!isset($ret[$task->getEvent()->getId()]))
            {
              $ret[$task->getEvent()->getId()] = array(
                  'object' => $task->getEvent(),
                  'days'   => array()
              );
            }

            if(!isset($ret[$task->getEvent()->getId()]['days'][$task->getStartsAt()->format('Ymd')]))
            {
              $ret[$task->getEvent()->getId()]['days'][$task->getStartsAt()->format('Ymd')] = array(
                  'display' => $task->getStartsAt()->format('F d, Y'),
                  'hours'   => array(),
              );
            }

            if(!isset($ret[$task->getEvent()->getId()]['days'][$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')]))
            {
              $ret[$task->getEvent()->getId()]['days'][$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')] = array(
                  'display' => $task->getStartsAt()->format('H:i A'),
                  'tasks'   => array(),
              );
            }

            $ret[$task->getEvent()->getId()]['days'][$task->getStartsAt()->format('Ymd')]['hours'][$task->getStartsAt()->format('HiA')]['tasks'][] = $task;
        }

        return $ret;
    }
}
