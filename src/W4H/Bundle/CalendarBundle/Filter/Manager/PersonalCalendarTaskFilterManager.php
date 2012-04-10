<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;


use W4H\Bundle\CalendarBundle\Filter\OnePersonFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class PersonalCalendarTaskFilterManager extends CalendarTaskFilterManager
{
    public function buildFilters($filterOptions = array())
    {
        parent::buildFilters($filterOptions);
        $this->addFilter(new OnePersonFilter($this->getContainer(), array('user_id' => $filterOptions['user_id'])), true)
             ->removeFilter('role');
    }
}
