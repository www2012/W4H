<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use W4H\Bundle\CalendarBundle\Filter\ScheduleFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class ScheduleTaskFilterManager extends EventListTaskFilterManager
{
    public function buildFilters($filterOptions = array())
    {
        $schedule = isset($filterOptions['schedule']) ? $filterOptions['schedule'] : false;

        parent::buildFilters($filterOptions);
        $this->addFilter(new ScheduleFilter($this->getContainer(), array(
                 'default_schedule' => $schedule
             )))
             ->removeFilter('from')
             ->removeFilter('to')
             ->removeFilter('activity')
             ->removeFilter('location')
             ->removeFilter('lucene_search')
        ;
    }
}
