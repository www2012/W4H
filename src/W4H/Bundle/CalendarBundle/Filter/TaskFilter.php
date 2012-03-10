<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class TaskFilter
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

    public abstract function getFilterName();
    public abstract function getFilterFormType();
    public abstract function getFilterFormOptions();
    public abstract function getData();
}
