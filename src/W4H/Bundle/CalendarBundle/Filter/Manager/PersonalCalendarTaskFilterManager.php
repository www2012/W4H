<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

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
        $this->removeFilter('person');
        $this->removeFilter('role');
    }
}
