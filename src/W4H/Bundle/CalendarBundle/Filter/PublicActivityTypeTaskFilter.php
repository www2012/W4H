<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\ActivityTypeTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class PublicActivityTypeTaskFilter extends ActivityTypeTaskFilter
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
