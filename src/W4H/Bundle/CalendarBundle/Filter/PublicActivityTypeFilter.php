<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class PublicActivityTypeFilter extends ActivityTypeFilter
{
    public function getQueryBuilder()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        $qb = $repository->createQueryBuilder('at')
               ->where('at.name NOT IN (\'Other\', \'Press\')');

        return $qb;
    }
}
