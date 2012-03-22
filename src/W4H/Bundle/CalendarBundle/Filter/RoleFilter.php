<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class RoleFilter extends AbstractEntityFilter
{
    public function getFilterName()      { return 'role'; }
    public function getEntityClass()     { return 'W4HUserBundle:Role'; }
    public function getFilterFormLabel() { return 'Role'; }

    public function getQueryBuilder()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        return $repository->findAllOrderedByNameQueryBuilder();
    }
}
