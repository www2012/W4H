<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use W4H\Bundle\CalendarBundle\Filter\Manager\TaskFilterManager;

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
        $this->addFilter(new DateTaskFilter($this->getContainer(), array(
            'filter_name' => 'day',
            'filter_form_label' => 'Day'
        )));
        parent::buildFilters();
        $this->removeFilter('from')
             ->removeFilter('to')
        ;
    }
}
