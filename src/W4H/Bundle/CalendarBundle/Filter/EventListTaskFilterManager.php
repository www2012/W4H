<?php
namespace W4H\Bundle\CalendarBundle\Filter;

use W4H\Bundle\CalendarBundle\Filter\PublicCalendarTaskFilterManager;

use W4H\Bundle\CalendarBundle\Filter\DateTaskFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class EventListTaskFilterManager extends PublicCalendarTaskFilterManager
{
    public function buildFilters()
    {
        $this->addFilter(new DateTaskFilter($this->getContainer(), array(
            'filter_name' => 'from',
            'filter_form_label' => 'From'
        )))
            ->addFilter(new DateTaskFilter($this->getContainer(), array(
            'filter_name' => 'to',
            'filter_form_label' => 'To'
        )));
        parent::buildFilters();
        $this->removeFilter('date');
    }
}
