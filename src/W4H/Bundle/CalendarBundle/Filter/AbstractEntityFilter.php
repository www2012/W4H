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
            'label'         => $this->getFilterFormLabel(),
            'class'         => $this->getEntityClass(),
            'query_builder' => $this->getQueryBuilder(),
            'required'      => true,
            'expanded'      => true,
            'multiple'      => true
        );
    }

    public function getFilteredData($filteredData = null)
    {
        if($filteredData != null)
            return parent::getFilteredData($filteredData);

        return $this->getQueryBuilder()->getQuery()->getResult();
    }

    public function getQueryBuilder()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $repository = $em->getRepository($this->getEntityClass());
        return $repository->createQueryBuilder('qb');
    }

    abstract public function getEntityClass();
    abstract public function getFilterFormLabel();
}
