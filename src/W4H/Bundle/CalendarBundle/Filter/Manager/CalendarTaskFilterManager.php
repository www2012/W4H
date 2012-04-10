<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use W4H\Bundle\CalendarBundle\Filter\DateFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CalendarTaskFilterManager extends TaskFilterManager
{
    public function buildFilters($filterOptions = array())
    {
        $default_day = isset($filterOptions['default_day']) ? $filterOptions['default_day'] : false;

        $this->addFilter(new DateFilter($this->getContainer(), array(
            'filter_name'       => 'day',
            'filter_form_label' => 'Day',
            'default_day'       => $default_day
        )));
        parent::buildFilters($filterOptions);
        $this->removeFilter('from')
             ->removeFilter('to')
        ;
    }
}
