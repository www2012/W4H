<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class OnePersonFilter extends PersonFilter
{
    public function getQueryBuilder()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        $qb = $repository->createQueryBuilder('p')
               ->where('p.id = :person_id')
               ->setParameter('person_id', $this->getOption('user_id'));

        return $qb;
    }
}
