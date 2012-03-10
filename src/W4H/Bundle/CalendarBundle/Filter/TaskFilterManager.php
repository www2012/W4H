<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\TaskFilter;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

/* Default Filters */
use W4H\Bundle\CalendarBundle\Filter\EventTaskFilter;
use W4H\Bundle\CalendarBundle\Filter\ActivityTypeTaskFilter;
use W4H\Bundle\CalendarBundle\Filter\ActivityTaskFilter;
use W4H\Bundle\CalendarBundle\Filter\LocationTaskFilter;
use W4H\Bundle\CalendarBundle\Filter\RoleTaskFilter;
use W4H\Bundle\CalendarBundle\Filter\PersonTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class TaskFilterManager
{
    protected $filters = array();
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->buildFilters();
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function buildFilters()
    {
        $this->addFilter(new EventTaskFilter($this->getContainer()))
             ->addFilter(new ActivityTypeTaskFilter($this->getContainer()))
             ->addFilter(new ActivityTaskFilter($this->getContainer()))
             ->addFilter(new LocationTaskFilter($this->getContainer()))
             ->addFilter(new RoleTaskFilter($this->getContainer()))
             ->addFilter(new PersonTaskFilter($this->getContainer()))
        ;
    }

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
     * @return TaskFilter
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
     * @param TaskFilter $filter
     * @param boolea $replace
     * @return TaskFilter The current filter
     */
    public function addFilter(TaskFilter $filter, $replace = false)
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
     */
    public function removeFilter($name)
    {
        if(!$this->hasFilter($name))
            throw new \Exception(sprintf('%s: Can\'t remove the missing filter %s',
              get_class($this),
              $name
            ));

        unset($this->filters[$name]);
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


    /**
     * getData
     *
     * @return array
     */
    public function getData()
    {
        $datas = array();
        foreach($this->getFilters() as $k => $filter)
        {
            $datas[$k] = $filter->getData();
        }

        return $datas;
    }
}
