<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\TaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class EntityTaskFilter extends TaskFilter
{
    public abstract function getEntityClass();
    public abstract function getFilterFormLabel();

    public function getFilterFormType()  { return 'entity'; }

    public function getFilterFormOptions()
    {
        return array(
            'class'    => $this->getEntityClass(),
            'label'    => $this->getFilterFormLabel(),
            'required' => true,
            'expanded' => true,
            'multiple' => true
        );
    }

    public function getFilteredData()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        return $repository->findAll();
    }
}
