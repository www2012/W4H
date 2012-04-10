<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class AbstractFilter
{
    protected $container;
    protected $options;

    public function __construct($container, $options = array())
    {
        $this->container = $container;
        $this->options = $options;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : false;
    }

    public function getFilteredData($filteredData = null)
    {
        if(isset($filteredData) && count($filteredData) > 0)
            return $filteredData;
    }

    abstract public function getFilterName();
    abstract public function getFilterFormType();
    abstract public function getFilterFormOptions();
}
