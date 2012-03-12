<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use W4H\Bundle\CalendarBundle\Filter\AbstractFilter;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class AbstractFilterManager
{
    protected $filters = array();
    protected $container;

    public function __construct($container, $filterOptions = array())
    {
        $this->container = $container;
        $this->buildFilters($filterOptions);
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     * buildFilters
     *
     * @param array $filterOptions
     */
    abstract public function buildFilters($filterOptions = array());

    /**
     * getData
     *
     * @param array $filteredData
     * @return array
     */
    abstract public function getFilteredData($filteredData = array());

    /**
     * hasFilter
     *
     * @param string $name
     * @return boolean
     */
    public function hasFilter($name)
    {
        return isset($this->filters[$name]);
    }

    /**
     * getFilter
     *
     * @param string $name
     * @return AbstractFilter
     */
    public function getFilter($name)
    {
        return $this->filters[$name];
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * addFilter
     *
     * @param AbstractFilter $filter
     * @param boolea $replace
     * @return AbstractFilterManager The current filter manager
     */
    public function addFilter(AbstractFilter $filter, $replace = false)
    {
        if($this->hasFilter($filter->getFilterName()) && !$replace)
            throw new \Exception(sprintf('%s: The filter %s is already present',
              get_class($this),
              $filter->getFilterName()
            ));

        $this->filters[$filter->getFilterName()] = $filter;

        return $this;
    }

    /**
     * removeFilter
     *
     * @param string $name
     * @return AbstractFilterManager The current filter manager
     */
    public function removeFilter($name)
    {
        if(!$this->hasFilter($name))
            throw new \Exception(sprintf('%s: Can\'t remove a missing filter %s',
              get_class($this),
              $name
            ));

        unset($this->filters[$name]);

        return $this;
    }

    /**
     * createForm
     *
     * @return Form
     */
    public function createForm()
    {
        $builder = $this->container->get('form.factory')->createNamedBuilder('form', 'task_filter_form');
        foreach($this->getFilters() as $filter)
        {
            $builder->add(
                $filter->getFilterName(),
                $filter->getFilterFormType(),
                $filter->getFilterFormOptions()
            );
        }

        return $builder->getForm();
    }
}
