<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\CalendarTaskFilterManager;

use W4H\Bundle\CalendarBundle\Filter\PublicActivityTypeTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class PublicCalendarTaskFilterManager extends CalendarTaskFilterManager
{
    public function buildFilters()
    {
        parent::buildFilters();
        $this->removeFilter('person');
        $this->removeFilter('role');
        $this->addFilter(new PublicActivityTypeTaskFilter($this->getContainer()), true);
    }
}
