<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class AbstractEntityFilter extends AbstractFilter
{
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

    abstract public function getEntityClass();
    abstract public function getFilterFormLabel();
}
