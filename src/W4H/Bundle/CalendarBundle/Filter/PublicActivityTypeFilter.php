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
    public function getFilterFormOptions()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());

        return array(
            'class'    => $this->getEntityClass(),
            'label'    => $this->getFilterFormLabel(),
            'query_builder' => $repository->createQueryBuilder('at')
               ->where('at.name NOT IN (\'Other\', \'Press\')'),
            'required' => true,
            'expanded' => true,
            'multiple' => true
        );
    }
}
