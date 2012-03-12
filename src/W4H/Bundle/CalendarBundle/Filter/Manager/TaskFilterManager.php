<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

/* Default Task Filters */
use W4H\Bundle\CalendarBundle\Filter\DateFilter;
use W4H\Bundle\CalendarBundle\Filter\EventFilter;
use W4H\Bundle\CalendarBundle\Filter\ActivityTypeFilter;
use W4H\Bundle\CalendarBundle\Filter\ActivityFilter;
use W4H\Bundle\CalendarBundle\Filter\LocationFilter;
use W4H\Bundle\CalendarBundle\Filter\RoleFilter;
use W4H\Bundle\CalendarBundle\Filter\PersonFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class TaskFilterManager extends AbstractFilterManager
{
    public function buildFilters($filterOptions = array())
    {
        $from_day = isset($filterOptions['from_day']) ? $filterOptions['from_day'] : false;
        $to_day = isset($filterOptions['to_day']) ? $filterOptions['to_day'] : false;

        $this->addFilter(new DateFilter($this->getContainer(), array(
                'filter_name'       => 'from',
                'filter_form_label' => 'From',
                'default_day'       => $from_day
            )))
            ->addFilter(new DateFilter($this->getContainer(), array(
                'filter_name'       => 'to',
                'filter_form_label' => 'To',
                'default_day'       => $to_day
            )))
            ->addFilter(new EventFilter($this->getContainer()))
            ->addFilter(new ActivityTypeFilter($this->getContainer()))
            ->addFilter(new ActivityFilter($this->getContainer()))
            ->addFilter(new LocationFilter($this->getContainer()))
            ->addFilter(new RoleFilter($this->getContainer()))
            ->addFilter(new PersonFilter($this->getContainer()))
        ;
    }

    /**
     * getData
     *
     * @param array $filteredData
     * @return array
     */
    public function getFilteredData($filteredData = array())
    {
        $datas = array();
        foreach($this->getFilters() as $k => $filter)
        {
            if(isset($filteredData[$k]) && count($filteredData[$k]) > 0)
                $datas[$k] = $filteredData[$k];
            elseif(!in_array($k, array('role', 'person')))
                $datas[$k] = $filter->getFilteredData();
        }

        return $datas;
    }
}
