<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\TaskFilterManager;

use W4H\Bundle\CalendarBundle\Filter\DateTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class CalendarTaskFilterManager extends TaskFilterManager
{
    public function buildFilters()
    {
        $this->addFilter(new DateTaskFilter($this->getContainer()));
        parent::buildFilters();
    }
}
