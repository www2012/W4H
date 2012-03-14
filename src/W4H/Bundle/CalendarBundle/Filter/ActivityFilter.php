<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class ActivityFilter extends AbstractEntityFilter
{
    public function getFilterName()      { return 'activity'; }
    public function getEntityClass()     { return 'W4HEventTaskBundle:Activity'; }
    public function getFilterFormLabel() { return 'Activity'; }

    public function getQueryBuilder()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        return $repository->findAllOrderedByNameQueryBuilder();
    }
}
