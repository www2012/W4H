<?php
namespace W4H\Bundle\CalendarBundle\Filter\Manager;

use W4H\Bundle\CalendarBundle\Filter\PublicActivityTypeFilter;
use W4H\Bundle\CalendarBundle\Filter\HideDataFilter;
use W4H\Bundle\CalendarBundle\Filter\LuceneSearchFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class EventListTaskFilterManager extends TaskFilterManager
{
    public function buildFilters($filterOptions = array())
    {
        parent::buildFilters($filterOptions);
        $this->removeFilter('person');
        $this->removeFilter('role');
        $this->addFilter(new PublicActivityTypeFilter($this->getContainer()), true)
             ->addFilter(new HideDataFilter($this->getContainer()))
             ->addFilter(new LuceneSearchFilter($this->getContainer()))
        ;
    }
}
